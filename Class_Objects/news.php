<?php
	class News{
		private $title;
		private $text;
		private $date;
	
		public function __construct($title, $date, $text ){
	            $this->title = $title;
	            $this->text = $text;
	            $this->date = $date;
	        }
	    public function getTitle(){
	            return $this->title;
	    }

	    public function getText(){
	            return $this->text;
	    }

        public function getDate(){
            return $this->date;
        }
        public function print(){
            echo "<p><b>$this->title</b></p>";
            echo "<p><i>$this->date</i></p>";
            echo "<div>$this->text</div>";
        }
    }

    $news=array();
    $news[] = new News(
    	'title ЭТО ЗАГОЛОВОК НОВОСТЕЙ',
    	'data ЭТО ДАТА НОВОСТЕЙ',
    	'text ЭТО ТЕКСТ НОВОСТЕЙ');
    $news[] = new News(
    	'title2 ЭТО ЗАГОЛОВОК ДРУГИХ НОВОСТЕЙ',
    	'data2 ЭТО ДАТА ДРУГИХ НОВОСТЕЙ',
    	'text2 ЭТО ТЕКСТ ДРУГИХ НОВОСТЕЙ');
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php foreach ($news as $new){
		$new->print();
	}
	?>
	
</body>
</html>