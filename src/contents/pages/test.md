---
layout: react
test: てすと
title: テスト
---

# ページのタイトル

```
{{$title}}
```
`{{$title}}`も変換されません。

```
<div></div> も変換されません。
```

## 見出し

```css
# ページのタイトルです(h1)
## 見出しレベル2(h2)
### 見出しレベル3(h3)
#### 見出しレベル4(h2)
##### 見出しレベル5(h5)
###### 見出しレベル6(h6)
```

h2 ~ 5 は自動的に目次として認識されます。

## 空行

###### × 悪い例
空行は単なる区切りですので、次のようにしても空行とはなりません。
```
空

行
```
###### 結果
{{:class note}}
空

行
{{/}}

###### △ よい例
`<br>` で空行ができます。なお `<br>` タグの上下には空行が必要です。
```
空

<br>   

行
```
###### 結果
{{:class note}}
空

<br>   

行
{{/}}

###### 〇 よい例
`{{:br}}` で空行ができます。上下に空行がなくても構いません。
```
空
{{:br}}   
行
```
###### 結果
{{:class note}}
空
{{:br}}   
行
{{/}}

###### さらに
空行はマージンでも表現できます。
デフォルトの１行の高さは `1.5rem` ですので、`{{:margin-top:1.5rem /}}` で空行と同じ効果が得られますが、おそらく多くの場合は１文字分すなわち `1rem` 空ければ十分でしょう。 
```
空
{{:margin-top:1rem /}}
行
```
###### 結果
{{:class note}}
空
{{:margin-top:1rem /}}
行
{{/}}

## 強調

_（アンダーライン）か * で囲むと、文字が強調されます。
__ （アンダーライン２つ）か ** で囲むと、文字が強調されます。
___ （アンダーライン３つ）か *** で囲むと、文字が強調されます。
なお、 * などの前後に半角スペースを入れると強調等にはなりません。

###### 例
```
文字が*強調*されます。
文字が**強調**されます。
文字が***強調***されます。
文字が * 強調 * されません。
```

###### 結果
{{:class note}}
文字が*強調*されます。
文字が**強調**されます。
文字が***強調***されます。
文字が * 強調 * されません。
{{/}}

## 打ち消し線

打ち消し線を使うには `<del> 文字 </del>` のようにします。

###### 例
```
<del>打ち消し</del>
```

###### 結果
{{:class note}}
<del>打ち消し</del>
{{/}}

## 文字の色

`{{:color:色}} 文字 {{/}}` で文字の色を変更できます。

###### 例
```
文字の色が{{:color:red}}変更{{/}}できます。
```

###### 結果
{{:class note}}
文字の色が{{:color:red}}変更{{/}}できます。
{{/}}

## 水平線

３つ以上連続したアスタリスク( * )、ハイフン( - )、アンダーラインは( _ )は水平線になります。 マークの間には２つまでの半角スペースがあっても構いません。

###### 例
```
以下はすべて水平線になります。
***
*****
*  *  *
- - -
---------------------------------------
________________
```

###### 結果
{{:class note}}
以下はすべて水平線になります。
***
*****
*  *  *
- - -
---------------------------------------
________________
{{/}}

## 番号なしリスト

```
* 文頭に「*」「+」「-」のいずれかを入れると順序なしリストになります
* 「*」「+」「-」の後ろには半角スペースが必要です。
  * 階層化できます。
    リスト内での改行。
  * 階層化できます。
    リスト内での改行。

\* リストにしたくない場合は「\」を付けてください。
```
###### 結果
{{:class note}}
* 文頭に「*」「+」「-」のいずれかを入れると順序なしリストになります
* 「*」「+」「-」の後ろには半角スペースが必要です。
  * 階層化できます。
    リスト内での改行。
  * 階層化できます。
    リスト内での改行。

\* リストにしたくない場合は「\\」を付けてください。
{{/}}

## 番号付きリスト

```
1. 文頭に「数字.」を入れると番号付きリストになります
1. 「数字.」の後ろには半角スペースが必要です。
  1. 階層化できます。
    リスト内での改行。
  1. 階層化できます。
    リスト内での改行。

1\. リストにしたくない場合は「\」を付けてください。
```
###### 結果
{{:class note}}
1. 文頭に「数字.」を入れると番号付きリストになります
1. 「数字.」の後ろには半角スペースが必要です。
  1. 階層化できます。
    リスト内での改行。
  1. 階層化できます。
    リスト内での改行。

1\. リストにしたくない場合は「\\」を付けてください。
{{/}}

## 引用

```
> 文頭に>を置くことで引用になります。
> 複数行にまたがる場合、改行のたびにこの記号を置く必要があります。
> 引用の上下にはリストと同じく空行がないと正しく表示されません。
> **引用の中に別のMarkdownを使用することも可能**です。
> 
> > これはネストされた引用です。
```
###### 結果
{{:class note}}
> 文頭に>を置くことで引用になります。
> 複数行にまたがる場合、改行のたびにこの記号を置く必要があります。
> 引用の上下にはリストと同じく空行がないと正しく表示されません。
> **引用の中に別のMarkdownを使用することも可能**です。
> 
> > これはネストされた引用です。
{{/}}

## インデント

`{{:class indent}}` を使用することでインデントできます。

###### 例
```
インデントなし
{{:class indent}}
  いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
  {{:class indent}}
    いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
  {{/}}
{{/}}
```

###### 結果

{{:class note}}
  インデントなし
  {{:class indent}}
    いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
    {{:class indent}}
      いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
    {{/}}
  {{/}}
{{/}}

###### さらに
１文字目だけインデントすることもできます。
```
{{:class text-indent}}
  いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
  {{:class indent text-indent}}
    いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
  {{/}}
{{/}}
```

###### 結果
{{:class note}}
  {{:class text-indent}}
    いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
    {{:class indent text-indent}}
      いんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんといんでんと
    {{/}}
  {{/}}
{{/}}


## 説明リスト

```
リンゴ
: {{:style:red}}赤い{{/}}フルーツ

ブドウ
: 山梨県が有名
: ワインの原料

レモン
オレンジ
: どちらもすっぱい
```
###### 結果
リンゴ
: {{:color:red}}赤い{{/}}フルーツ

ブドウ
: 山梨県が有名
: ワインの原料

レモン
オレンジ
: どちらもすっぱい

## ノート

###### 例
```
{{:class note}}
  {{:class title}}タイトル{{/}}
  普通のノート
{{/}}

{{:class note info}}
  {{:class title}}タイトル{{/}}
  インフォメーションノート
{{/}}

{{:class note warning}}
  {{:class title}}タイトル{{/}}
  ワーニングノート
{{/}}

{{:class note error}}
  {{:class title}}タイトル{{/}}
  エラーノート
{{/}}

{{:class note reverse}}
  {{:class title}}タイトル{{/}}
  リバースノート
{{/}}
```

###### 結果
{{:class note}}
  {{:class title}}タイトル{{/}}
  普通のノート
{{/}}

{{:class note info}}
  {{:class title}}タイトル{{/}}
  インフォメーションノート
{{/}}

{{:class note warning}}
  {{:class title}}タイトル{{/}}
  ワーニングノート
{{/}}

{{:class note error}}
  {{:class title}}タイトル{{/}}
  エラーノート
{{/}}

{{:class note reverse}}
  {{:class title}}タイトル{{/}}
  リバースノート
{{/}}

-------------------------------------

<div id="box1">
**この行の*は変換されずにそのまま表示されます。**
</div>

販売している電子書籍のファイルとしてPDF[^pdf]とEPUB[^epub]があります。

[^pdf]: 紙書籍のレイアウトを維持しています。Adobe Readerなどを使って読めます。
[^epub]: 紙のレイアウトとは異なります。Thorium Readerなどを使って読めます。

そのため、自分の環境に合わせて利用できます。

## 折り畳み

`<details><summary></summary></details>` を使うと折り畳みコンテンツが書けます。


###### 〇 良い例
```
<details><summary>詳細を見たければクリック！</summary>

(上に空行が必要)

* 詳細な情報です。
* 詳細な情報です。
</details>
```

###### 結果
<details><summary>詳細を見たければクリック！</summary>

(上に空行が必要)

* 詳細な情報です。
* 詳細な情報です。
</details>

###### × 悪い例
```
<details><summary>詳細を見たければクリック！</summary>
(上に空行がないと Markdown として認識されません)

* 詳細な情報です。
* 詳細な情報です。
</details>
```

###### 結果

<details><summary>詳細を見たければクリック！</summary>
(上に空行がないと Markdown として認識されません)

* 詳細な情報です。
* 詳細な情報です。
</details>

###### さらに
階層化もできます。
```
<details><summary>詳細を見たければクリック！</summary>

<details><summary>詳細を見たければクリック！</summary>

* 詳細な情報です。
* 詳細な情報です。
</details>

* 詳細な情報です。
* 詳細な情報です。
</details>
```
###### 結果
<details><summary>詳細を見たければクリック！</summary>

<details><summary>詳細を見たければクリック！</summary>

* 詳細な情報です。
* 詳細な情報です。
</details>

* 詳細な情報です。
* 詳細な情報です。
</details>



---

## ABC

#### あいうえお

* １２３
  456
 * nexy
* 23

用語1
: 説明。説明。説明。説明。説明。説明。説明。

| a | b | c| d |
|---|---|---|---|
| y | n | y | y |
| n |^^ | n | y |
| y | n | y    ||

- [ ] 1
- [x] 2

<details>
<summary>xxx</summary>

aaaaaaaaaaaaaaaaaaaaa
bbbbbbbbbbbbbbbbbbb
ccccccccccccccccccccc
</details>

## スタイル

```
{{:style color:red}}
* 文字色を赤にする
{{:/}}
```

{{:style color:red}}

* 文字色を赤にする

{{:/}}


## 特殊文字

### コードスパン、コードブロック内の特殊文字はそのまま表示されます。

#### コードスパン
```
`<div>そのまま表示</div>`
```
↓
`<div>そのまま表示</div>`

#### コードブロック
~~~
```
<div>そのまま表示</div>
```
~~~
↓
```
<div>そのまま表示</div>
```

### コードスパンの中に ` を表示するには

```
`` ` ``
```
↓
`` ` ``

`\` を付けることで Markdown として認識されてしまうことを防げます。

{{:style margin-top:1rem/}}
例
: `\*` とすることで、

`\` 自体を表示したい場合は `\\` とします。

&lt;
\*
`<` は `&lt;` と記述してください。

&lcub;
`{` は `\{` と記述してください。
\{\{

```
`
```
&#96;

{{test}}
{{test2}}
