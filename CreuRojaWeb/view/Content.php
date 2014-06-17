<?php
interface Content {
	public function showContent(Notice $notices);
	public function getHtmlHeaders();
}