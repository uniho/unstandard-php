# index.php

## function spl_autoload_register()
クラスのオートロード。ようは Composer と同様のことをする。

## class MDJ
*1
frontmatter での `!include ファイル名` の処理。

*2 
改行コードを \n に統一することで、正規表現が書きやすくなる。

*3
body での `{{!include ファイル名}}` の処理。
コードブロック内にも書ける。逆にいうと、インクルードしたくない場合はエスケープが必要。


## class MarkdownCustom

*1
コードブロックとコードスパン内の `{` を `\{` に変換することで、Mustache の対象外にする。 

*2
`{{:tag}}` を HTML タグに変換する。
`{{\}}` を クロージングタグ に変換する。

*3
`markdown="1"` とすることで、inner も Markdown として処理される。
インラインタグでは不要。

*4-1 class MarkdownCustom->handleMarkdown() 内
`Indented code block` の正規表現をコメントに。

*4-2 class MarkdownCustom->handleMarkdown() 内
`<details>` タグ内で、改行の数により markdown="1" を付加する。

*5
prism.js に対応させるため code_class_prefix に language- をつける。

*6
改行を `<br/>` に変換する。

*7
h1~6 の id を生成する。

*8
コードブロックの処理。
`` \` `` を `` ` `` に戻す。
`\{` を `{` に戻す。
`\` を `\\` に変換する。
`&<>` をコードに変換する。

*9
コードスパンの処理。
`\{` を `{` に戻す。
`\` を `\\` に変換する。
`&<>` をコードに変換する。

*10
h1~6 を解析する。

*11
h1~6 をリンク化する。

*12
style タグを分離する。
