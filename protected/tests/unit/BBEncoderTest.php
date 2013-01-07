<?php


class BBEncoderTest extends CTestCase
{

    private $exampleData = <<<TEST

        [b]hi[/b] [b]<script>alert('hi');</script>[/b]
        [u]aoeu[/u] [b]<script>alert('hi');</script>[/b]

        <script>alert('hi');</script>
        [url=script:alert(document.cookie)]cool_url[/url]

        [php]<?php echo 'hi';[/php]
        [php]<script>alert(document.cookie);[/php]

        [left]blabla[/left]
        [html]<span class='s'><abbr>aoeu</abbr></span>[/html]

TEST;


    public function testEncodeForXss()
    {
        $encoder = new BBencoder($this->exampleData, '<script>alert("hi");</script>', false);
        $encoded = $encoder->GetParsedHtml();

        $this->assertNotContains('<script>', $encoded);
        $this->assertNotContains('href="script', $encoded);
    }


    public function testEncodeForBoldTag()
    {
        $encoder = new BBencoder($this->exampleData, 'yo title', false);
        $result = $encoder -> GetParsedHtml();

        $this->assertContains('<strong>hi</strong>', $result);
    }

    public function testEncodeForUnderlineTag()
    {
        $encoder = new BBencoder($this->exampleData, 'yo title', false);
        $result = $encoder -> GetParsedHtml();

        $this->assertContains('<span class="underline">aoeu</span>', $result);
    }

    public function testColorizedCodePresense()
    {
        $encoder = new BBencoder($this->exampleData, 'yo title', false);
        $result = $encoder -> GetParsedHtml();
        $this->assertContains('<div class="php codeblock">', $result);
    }

    public function testLeft()
    {
        $encoder = new BBencoder($this->exampleData, 'yo title', false);
        $result = $encoder -> GetParsedHtml();
        $this->assertNotContains("[left]", $result);
        $this->assertContains("dirleft", $result);
    }

    public function testLeft2()
    {
    	$encoder = new BBencoder("[left]
    			aoeuaoeu
    			[/left]", 'yo title', false);
    	$result = $encoder -> GetParsedHtml();
    	$this->assertNotContains("[left]", $result);
    	$this->assertContains("dirleft", $result);
    }

    public function testHtml()
    {
        $encoder = new BBencoder($this->exampleData, 'yo title', true);
        $result = $encoder -> GetParsedHtml();

        $this->assertContains("<span class='s'><abbr>aoeu</abbr></span>", $result);
    }

    public function testAutoLtr()
    {
        $string = 'תגיד שלום באנגלית: hello';
        $expected = 'תגיד שלום באנגלית: <span dir="ltr">hello</span>';
        $actual = BBencoder::autoLtr($string);
        $this->assertEquals($expected, $actual);
    }

    public function testAutoLtrVariable()
    {
        $string = 'תגיד שלום באנגלית: $myvar';
        $expected = 'תגיד שלום באנגלית: <span dir="ltr">$myvar</span>';
        $actual = BBencoder::autoLtr($string);
        $this->assertEquals($expected, $actual);
    }

    public function testAutoLtrSomeInlineCode()
    {
        $string = 'תנסה לעשות function yo(&$var) {echo "$var"; }; טוב';
        $expected = 'תנסה לעשות <span dir="ltr">function yo(&$var) {echo "$var"; };</span> טוב';
        $actual = BBencoder::autoLtr($string);
        $this->assertEquals($expected, $actual);
    }
}

