<?php

ini_set('display_errors', 1);

spl_autoload_register(function($class_name) {
  $DS = DIRECTORY_SEPARATOR;
  $s = str_replace('\\', $DS, $class_name);
  $file_name = "bd{$DS}modules{$DS}{$s}.php";
  if (is_file($file_name)) {
    require_once $file_name;
    return;
  }
});

function notFound($resource) {
  header("HTTP/1.1 404 Not Found");
  echo "404 $resource Not Found.";
  exit();
}

class MDJ {
  // private $nest = 0;
	// public function __construct() {
  //   $this->nest = 0;
  // }
  public function split($contents, $nest = 0, $block = 0) {
    if ($nest >= 10) throw new \Exception('too many nest in frontmatter.');
    $frontmatter = '';
    $body = '';
    if (preg_match('{^\s*?---\s+([\S\s]*?)\s+---\s*([\S\s]*)$}', $contents, $match)) {
      $frontmatter = $match[1];
      if ($nest == 0) $frontmatter = "!include _default\n$frontmatter";  
      $frontmatter = preg_replace_callback('{\!include[ \t]+(\S+)}', function($match) use($nest){
        // *1
        $fn = './contents/pages/' . str_replace('.', '', $match[1]) . '.md';
        if (!is_file($fn)) notFound($fn);
        $md = $this->split(file_get_contents($fn), $nest+1, 1);
        return $md['fm'];
      }, $frontmatter);

      if ($block != 1 && count($match) > 2) {
        $body = preg_replace('{\r\n?}', "\n", $match[2]); // *2
        if ($nest == 0) $body .= "\n{{!include _default}}";  
        $body = preg_replace_callback('/(^|\n){{\!include[ \t]+(\S+)\s*}}($|\n)/', function($match) use($nest){
          // *3
          $fn = './contents/pages/' . str_replace('.', '', $match[2]) . '.md';
          if (!is_file($fn)) notFound($fn);
          $md = $this->split(file_get_contents($fn), $nest+1);
          return $md['body'];
        }, $body);
      }
    }  
    return ['fm' => $frontmatter, 'body' => $body];
  }
}

function handleLayout($props) {
  $fn = './contents/layouts/' . $props['frontmatter']['layout'] . '.md';
  if (!is_file($fn)) notFound($fn);
  $rawContent = file_get_contents($fn);
  $MDJ = new MDJ();
  $md = $MDJ->split($rawContent, 1);
  $layoutBody = $md['body'];
  if (isset($md['fm']['layout'])) {
    $layoutBody = handleLayout($layoutBody, $md['fm']);
  }
  $json = json_encode($props);
  $result = preg_replace('/{\s*?markdown\s*?:\s*?"<slot\/>"\s*?}/', $json, $layoutBody);
  $result = preg_replace('{<slot\s*?/>}', $props['content'], $result);
  return $result;
}

function handleMarkdown($match) {
  $fn = './contents/pages/' . $match[1] . '.md';
  if (!is_file($fn)) notFound($fn);
  $rawContent = file_get_contents($fn);
  $MDJ = new MDJ();
  $md = $MDJ->split($rawContent);
  $frontmatter = array_replace_recursive(Defines::FRONT_MATTER, Spyc::YAMLLoadString($md['fm']));
  $midContent = $md['body'];

  $markdown = new MarkdownCustom();
  $markdown->code_class_prefix = 'language-'; // *5
  $markdown->hard_wrap = true; // *6
  $markdown->header_id_func = function($val) {
    // *7
    return uniqid();
  };
  $markdown->code_block_content_func = function($codeblock) {
    // *8
    // $codeblock = str_replace('\\`', '`', $codeblock);
    $codeblock = str_replace('\\{', '{', $codeblock);
    $codeblock = str_replace('\\', '\\\\', $codeblock);
    $codeblock = htmlspecialchars($codeblock, ENT_NOQUOTES);
    return $codeblock;
  };
  $markdown->code_span_content_func = function($codeblock) {
    // *9
    $codeblock = str_replace('\\{', '{', $codeblock);
    $codeblock = str_replace('\\', '\\\\', $codeblock);
    $codeblock = htmlspecialchars($codeblock, ENT_NOQUOTES);
    return $codeblock;
  };
  $midContent = $markdown->transform2($midContent, $frontmatter);

  // *10
  // $headings = [];
  // if (preg_match_all('{<h([2-6])\s+id="(\S+)"\s*[^>]*>(.+?)</h\1>}', $midContent, $match, PREG_SET_ORDER)) {
  //   foreach ($match as $m) {
  //     $headings[] = [
  //       'depth' => (int)$m[1],
  //       'slug' => $m[2],
  //       'text' => html_entity_decode($m[3]),
  //     ];
  //   }
  // }

  // // *11
  // $midContent = preg_replace('{<h([2-6])\s+id="(\S+)"\s*[^>]*>(.+?)</h\1>}', '<h$1 id="$2"><a href="#$2">$3</a></h$1>', $midContent);

  // *12
  $styles = '';
  $midContent = preg_replace_callback('{<style>([\S\s]+?)</style>}',
    function($match) use(&$styles) {
      $styles .= $match[1];
      return '';
    },
    $midContent);

  $compiledContent = $midContent;
  $layoutedContent = $compiledContent;
  if (isset($frontmatter['layout'])) {
    $props = [];
    $props['content'] = $layoutedContent;
    if (!$frontmatter) $frontmatter = [];
    $props['frontmatter'] = $frontmatter;
    $props['headings'] = $markdown->headings;
    $props['style'] = $styles;
    $layoutedContent = handleLayout($props);
  }

  $ctype = 'text/html; charset=utf-8';

  header("HTTP/1.1 200 OK");
  header("Status: 200");
  header("Content-Type: {$ctype}");
  echo $layoutedContent;
  exit();
}

try {
  //
  $uri = $_SERVER['REQUEST_URI'];
  $query = rawurldecode(parse_url($uri, PHP_URL_QUERY));

  //
  if (preg_match("/^rest_route=(.+)$/", $query, $match)) {
    if (preg_match('{unsta/v1/api/(?P<cmd>[\\w\\d\\-]+)/(?P<arg>[\\w\\d\\-]+)(?:/|&|$)}', $match[1], $match)) {
      echo $_SERVER['REQUEST_METHOD'];
      $request = [];
      foreach ($match as $key => $value) {
        if (!is_int($key)) $request[$key] = $value;
      }  
      foreach ($_REQUEST as $key => $value) {
        if ($key != 'rest_route') $request[$key] = $value;
      }  
      echo var_dump($request);
    }
    exit();
  }

  //
  if (preg_match("/^markdown=(.+)$/", $query, $match)) {
    handleMarkdown($match);
  }
} catch (\Exception $e) {
  header("HTTP/1.1 500 Internal Server Error");
  echo $e->getMessage();
}

?>

<div>NO</div>