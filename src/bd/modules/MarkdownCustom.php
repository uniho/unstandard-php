<?php

class MarkdownCustom extends Michelf\MarkdownExtra {

	public $headings = [];
	private $mustache;

	public function __construct() {
		require_once 'bd/modules/Mustache/Autoloader.php';
		Mustache_Autoloader::register();
		$this->mustache = new Mustache_Engine();
		parent::__construct();
	}

	public function transform2(string $text, $frontmatter): string {
		$this->setup();

		$this->headings = [];

		# Remove UTF-8 BOM and marker character in input, if present.
		// $text = preg_replace('{^\xEF\xBB\xBF|\x1A}', '', $text);

		# Standardize line endings:
		#   DOS to Unix and Mac to Unix
		// $text = preg_replace('{\r\n?}', "\n", $text);

		# Make sure $text ends with a couple of newlines:
		$text .= "\n\n";

		# Convert all tabs to spaces.
		$text = $this->detab($text);

		// *1		
    $text = preg_replace_callback('{($|\n|[^`\\\])(`+)[^`]+\2}',
      function($match) {
        return str_replace('{', '\{', $match[0]);
      }, $text);

		{
			// *2
			$tags = [];
			$text = preg_replace_callback('/({{2,})([:\/])([^}\/]*)(\/)?(}{2,})/',
				function($match) use(&$tags) {
					if (strlen($match[1]) != strlen($match[5])) {
						return $match[0];
					}
					if ($match[2] == '/') {
						$tag = array_pop($tags);
						if (!$tag) return $match[0];
						return "</$tag>";
					}

					$tag = $match[3];
					$attr = preg_match('/([^ :]+)([ :]+)([^ ]+[\S\s]*)/', $tag, $m1);
					if ($attr) $tag = $m1[1];
					$tag = trim($tag);
					if (!$tag) return $match[0];
					
					if ($attr) {
						if (preg_match('{(style|class)(-*)}', $tag, $m2)) {
							if ($m2[2]) {
								$tag = $m2[1];
								$tags[] = 'span';
								$result = "<span $tag=\"{$m1[3]}\">"; 
								if ($match[4] == '/') $result .= "</span>"; 
								return $result; 
							}
							$tags[] = 'div';
							$result = "<div $tag=\"{$m1[3]}\" markdown=\"1\">"; // *3 
							if ($match[4] == '/') $result .= "</div>"; 
							return "\n$result\n"; 
						}
						if (preg_match('{^(margin|padding)}', $tag, $m2)) {
							$tags[] = 'div';
							$result = "<div style=\"$tag:{$m1[3]}\" markdown=\"1\">"; // *3 
							if ($match[4] == '/') $result .= "</div>"; 
							return "\n$result\n"; 
						}
						if (preg_match('{^(color)}', $tag, $m2)) {
							$tags[] = 'span';
							$result = "<span style=\"$tag:{$m1[3]}\">";
							if ($match[4] == '/') $result .= "</span>"; 
							return $result; 
						}
					} else {
						if (preg_match('{^br[ ]*([/S/s]*)$}', $tag, $m2)) {
							return "\n<br/>\n"; 
						}	
					}

					$tags[] = $tag;
					$result = '<'.$match[3].' markdown="1">'; // *3 
					if ($match[4] == '/') $result .= "</$tag>"; 
					return $result;
				}, $text);

			$text = $this->mustache->render($text, $frontmatter);
		}

		# Turn block-level HTML blocks into hash entries
		$text = $this->hashHTMLBlocks($text);

		# Strip any lines consisting only of spaces and tabs.
		# This makes subsequent regexen easier to write, because we can
		# match consecutive blank lines with /\n+/ instead of something
		# contorted like /[ ]*\n+/ .
		$text = preg_replace('/^[ ]+$/m', '', $text);

		# Run document gamut methods.
		foreach ($this->document_gamut as $method => $priority) {
			$text = $this->$method($text);
		}

		$this->teardown();

		return $text . "\n";
	}

	protected function doHeaders($text) {
		/**
		 * Setext-style headers:
		 *	  Header 1
		 *	  ========
		 *
		 *	  Header 2
		 *	  --------
		 */
		// $text = preg_replace_callback('{ ^(.+?)[ ]*\n(=+|-+)[ ]*\n+ }mx',
		// 	array($this, '_doHeaders_callback_setext'), $text);

		/**
		 * atx-style headers:
		 *   # Header 1
		 *   ## Header 2
		 *   ## Header 2 with closing hashes ##
		 *   ...
		 *   ###### Header 6
		 */
		$text = preg_replace_callback('{
				^(\#{1,6})	# $1 = string of #\'s
				[ ]*
				(.+?)		# $2 = Header text
				[ ]*
				\#*			# optional closing #\'s (not counted)
				\n+
			}xm',
			array($this, '_doHeaders_callback_atx'), $text);

		return $text;
	}

	protected function _doHeaders_callback_atx($matches) {
		// ID attribute generation
		$idAtt = $this->_generateIdFromHeaderValue($matches[2]);
		$level = strlen($matches[1]);
		$block = "<h$level$idAtt>".$this->runSpanGamut($matches[2])."</h$level>";

		if ($level > 1 && $level < 6) {
			$slug = '';
			if (preg_match('{id\s*=\s*"([^"]*)"}', $idAtt, $m)) {
				$slug = $m[1];
			}
			$this->headings[] = [
        'depth' => $level,
        'slug' => $slug,
        'text' => html_entity_decode($matches[2]),
			];
			$block = "<h$level$idAtt><a href=\"#$slug\">{$this->runSpanGamut($matches[2])}</a></h$level>";
		}

		return "\n" . $this->hashBlock($block) . "\n\n";
	}

	protected function doCodeBlocks($text) {
		/*
		$text = preg_replace_callback('{
				(?:\n\n|\A\n?)
				(	            # $1 = the code block -- one or more lines, starting with a space/tab
				  (?>
					[ ]{'.$this->tab_width.'}  # Lines must start with a tab or a tab-width of spaces
					.*\n+
				  )+
				)
				((?=^[ ]{0,'.$this->tab_width.'}\S)|\Z)	# Lookahead for non-space at line-start, or end of doc
			}xm',
			array($this, '_doCodeBlocks_callback'), $text);
		*/
		
		return $text;
	}

	protected function _hashHTMLBlocks_inMarkdown($text, $indent = 0,
										$enclosing_tag_re = '', $span = false)
	{

		if ($text === '') return array('', '');

		// Regex to check for the presense of newlines around a block tag.
		$newline_before_re = '/(?:^\n?|\n\n)*$/';
		$newline_after_re =
			'{
				^						# Start of text following the tag.
				(?>[ ]*<!--.*?-->)?		# Optional comment.
				[ ]*\n					# Must be followed by newline.
			}xs';

		// *4-1
		// Regex to match any tag.
		$block_tag_re =
			'{
				(					# $2: Capture whole tag.
					</?					# Any opening or closing tag.
						(?>				# Tag name.
							' . $this->block_tags_re . '			|
							' . $this->context_block_tags_re . '	|
							' . $this->clean_tags_re . '        	|
							(?!\s)'.$enclosing_tag_re . '
						)
						(?:
							(?=[\s"\'/a-zA-Z0-9])	# Allowed characters after tag name.
							(?>
								".*?"		|	# Double quotes (can contain `>`)
								\'.*?\'   	|	# Single quotes (can contain `>`)
								.+?				# Anything but quotes and `>`.
							)*?
						)?
					>					# End of tag.
				|
					<!--    .*?     -->	# HTML Comment
				|
					<\?.*?\?> | <%.*?%>	# Processing instruction
				|
					<!\[CDATA\[.*?\]\]>	# CData Block
				' . ( !$span ? ' # If not in span.
				|
					# Indented code block
#					(?: ^[ ]*\n | ^ | \n[ ]*\n )
#					[ ]{' . ($indent + 4) . '}[^\n]* \n
#					(?>
#						(?: [ ]{' . ($indent + 4) . '}[^\n]* | [ ]* ) \n
#					)*
#				|
					# Fenced code block marker
					(?<= ^ | \n )
					[ ]{0,' . ($indent + 3) . '}(?:~{3,}|`{3,})
					[ ]*
					(?: \.?[-_:a-zA-Z0-9]+ )? # standalone class name
					[ ]*
					(?: ' . $this->id_class_attr_nocatch_re . ' )? # extra attributes
					[ ]*
					(?= \n )
				' : '' ) . ' # End (if not is span).
				|
					# Code span marker
					# Note, this regex needs to go after backtick fenced
					# code blocks but it should also be kept outside of the
					# "if not in span" condition adding backticks to the parser
					`+
				)
			}xs';


		$depth = 0;		// Current depth inside the tag tree.
		$parsed = "";	// Parsed text that will be returned.

		// Loop through every tag until we find the closing tag of the parent
		// or loop until reaching the end of text if no parent tag specified.
		do {
			// Split the text using the first $tag_match pattern found.
			// Text before  pattern will be first in the array, text after
			// pattern will be at the end, and between will be any catches made
			// by the pattern.
			$parts = preg_split($block_tag_re, $text, 2,
								PREG_SPLIT_DELIM_CAPTURE);

			// If in Markdown span mode, add a empty-string span-level hash
			// after each newline to prevent triggering any block element.
			if ($span) {
				$void = $this->hashPart("", ':');
				$newline = "\n$void";
				$parts[0] = $void . str_replace("\n", $newline, $parts[0]) . $void;
			}

			$parsed .= $parts[0]; // Text before current tag.

			// If end of $text has been reached. Stop loop.
			if (count($parts) < 3) {
				$text = "";
				break;
			}

			$tag  = $parts[1]; // Tag to handle.
			$text = $parts[2]; // Remaining text after current tag.

			// Check for: Fenced code block marker.
			// Note: need to recheck the whole tag to disambiguate backtick
			// fences from code spans
			if (preg_match('{^\n?([ ]{0,' . ($indent + 3) . '})(~{3,}|`{3,})[ ]*(?:\.?[-_:a-zA-Z0-9]+)?[ ]*(?:' . $this->id_class_attr_nocatch_re . ')?[ ]*\n?$}', $tag, $capture)) {
				// Fenced code block marker: find matching end marker.
				$fence_indent = strlen($capture[1]); // use captured indent in re
				$fence_re = $capture[2]; // use captured fence in re
				if (preg_match('{^(?>.*\n)*?[ ]{' . ($fence_indent) . '}' . $fence_re . '[ ]*(?:\n|$)}', $text,
					$matches))
				{
					// End marker found: pass text unchanged until marker.
					$parsed .= $tag . $matches[0];
					$text = substr($text, strlen($matches[0]));
				}
				else {
					// No end marker: just skip it.
					$parsed .= $tag;
				}
			}
			// Check for: Indented code block.
			else if ($tag[0] === "\n" || $tag[0] === " ") {
				// Indented code block: pass it unchanged, will be handled
				// later.
				$parsed .= $tag;
			}
			// Check for: Code span marker
			// Note: need to check this after backtick fenced code blocks
			else if ($tag[0] === "`") {
				// Find corresponding end marker.
				$tag_re = preg_quote($tag);
				if (preg_match('{^(?>.+?|\n(?!\n))*?(?<!`)' . $tag_re . '(?!`)}',
					$text, $matches))
				{
					// End marker found: pass text unchanged until marker.
					$parsed .= $tag . $matches[0];
					$text = substr($text, strlen($matches[0]));
				}
				else {
					// Unmatched marker: just skip it.
					$parsed .= $tag;
				}
			}
			// Check for: Opening Block level tag or
			//            Opening Context Block tag (like ins and del)
			//               used as a block tag (tag is alone on it's line).
			else if (preg_match('{^<(?:' . $this->block_tags_re . ')\b}', $tag) ||
				(	preg_match('{^<(?:' . $this->context_block_tags_re . ')\b}', $tag) &&
					preg_match($newline_before_re, $parsed) &&
					preg_match($newline_after_re, $text)	)
				)
			{

				// *4-2
				if ($tag == '<details>') {
					preg_replace_callback('{([\S\s]+?)</details>}', function($m) use(&$tag){
						if (preg_match('{^\n\n|</summary>\n\n}', $m[1])) {
							$tag = '<details markdown="1">';
						}
						return $m[0];
					}, $text, 1);
				}

				// Need to parse tag and following text using the HTML parser.
				list($block_text, $text) =
					$this->_hashHTMLBlocks_inHTML($tag . $text, "hashBlock", true);

				// Make sure it stays outside of any paragraph by adding newlines.
				$parsed .= "\n\n$block_text\n\n";
			}
			// Check for: Clean tag (like script, math)
			//            HTML Comments, processing instructions.
			else if (preg_match('{^<(?:' . $this->clean_tags_re . ')\b}', $tag) ||
				$tag[1] === '!' || $tag[1] === '?')
			{
				// Need to parse tag and following text using the HTML parser.
				// (don't check for markdown attribute)
				list($block_text, $text) =
					$this->_hashHTMLBlocks_inHTML($tag . $text, "hashClean", false);

				$parsed .= $block_text;
			}
			// Check for: Tag with same name as enclosing tag.
			else if ($enclosing_tag_re !== '' &&
				// Same name as enclosing tag.
				preg_match('{^</?(?:' . $enclosing_tag_re . ')\b}', $tag))
			{
				// Increase/decrease nested tag count.
				if ($tag[1] === '/') {
					$depth--;
				} else if ($tag[strlen($tag)-2] !== '/') {
					$depth++;
				}

				if ($depth < 0) {
					// Going out of parent element. Clean up and break so we
					// return to the calling function.
					$text = $tag . $text;
					break;
				}

				$parsed .= $tag;
			}
			else {
				$parsed .= $tag;
			}
			// @phpstan-ignore-next-line
		} while ($depth >= 0);

		return array($parsed, $text);
	}

}
