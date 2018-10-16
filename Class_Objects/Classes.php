
<?php
class Car{
	private $model;
	private $color;
	private $maxSpeed;

	public function __construct($model, $color, $maxSpeed){
		$this -> model = $model;
		$this -> color = $color;
		$this -> maxSpeed = $maxSpeed;
	}
	public function getModel(){
		return $this -> model;
	}

	public function getColor(){
		return $this -> color;
	}

	public function getMaxSpeed(){
		return $this -> maxSpeed;
	}
}
$audi = new Car("Audi", "Red", 220);
$volvo = new Car("Volvo", "Black", 240);
echo ('model is '.$audi->getModel().'<br>');
echo ('color is '.$audi->getColor().'<br>');
echo ('max speed is '.$audi->getMaxSpeed().'<br>');//для проверок.




class TV{
	public $diagonal;
	public $model;
}
$samsung = new TV();
$samsung->diagonal = 55;
$samsung->model = "Samsung";
echo ('model is '.$samsung->model.' with diagonal '. $samsung->diagonal.'<br>');

$lg = new TV();
$lg->diagonal = 47;
$lg->model = "LG";

class Pen{
	private $length;
	private $model;

	public function __construct($model, $length){
		$this->model = $model;
		$this->length = $length;
	}
	public function getAll(){
		echo ('model is '.$this->model.' with lenght '.$this->length. 'cm<br>');
	}
}
$parker = new Pen('parker', 10);
$parker->getAll();
$anotherPen = new Pen('Another', 8);
$anotherPen->getAll();


class Duck{
	public $speed;
	public $isFly;
	public $weight; 
}

$duck1 = new Duck();
$duck1->speed = 13;
$duck1->isFly = false;
$duck1->weight = 120;
echo ('duck №1 : speed - '.$duck1->speed.'<br>');
echo 'Can he fly? - ',$duck1->isFly ? 'yes' : 'no', '<br>';
echo ('his weight - '.$duck1->weight.'<br>');



class Product{

	private $name;
	private $price;
	private $discount;

	public function __construct($name, $price, $discount){
		$this->name = $name;
		$this->price = $price;
		$this->discount = $discount;
	}

	public function setDiscount(){		
		if ($this->discount){
			$this->price *= 1 - $this->discount/100;
		}
		else {
			$this->price = 'no discount';// уверен,что это не верно - но работает. в пхп нет строгой типизации...
		}
		return $this->price;
	}
}
$wheel = new Product("Mishlen", 120, 10);
$book = new Product("Harry", 200, 0);
echo $wheel->setDiscount();
echo ('<br>');
echo $book->setDiscount();


?>