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
}

