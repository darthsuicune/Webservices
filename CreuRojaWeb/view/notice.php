<?php class Notice {
	const NOTICE_TYPE_ERROR = "error";
	const NOTICE_TYPE_NOTICE = "notice";
	
	var $notices;
	var $type;
	var $title;
	
	public function __construct(Strings $lang, array $notices = null) {
		$this->notices = $notices;
		$this->type = $notices[0];
		$this->setTitle($lang);
		array_shift($this->notices);
	}

	public function showNotice() {
		?>
<div id="<?php echo $this->type; ?>">
	<h4>
		<?php echo $this->title; ?>
	</h4>
	<ul><?php 
		foreach ($this->notices as $notice) { ?>
		<li><?php echo $notice; 
		} ?>
	</ul>
</div>
<?php }

	function setTitle($lang) {
		switch ($this->type) {
			case self::NOTICE_TYPE_ERROR:
				$this->title = $lang->get(Strings::ERRORS_TITLE);
				break;
			case self::NOTICE_TYPE_NOTICE:
				$this->title = $lang->get(Strings::NOTICE_TITLE);
				break;
			default:
				break;
		}
	}
}?>