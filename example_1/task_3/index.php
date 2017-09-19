<?php
/*Реализовать на PHP структуру классов, описывающих геометрические фигуры: прямоугольник, круг, треугольник.
Описать метод для вычисления площади фигуры.
Получить объекты фигур, используя данные из приложенного файла figures.json
Отсортировать полученную коллекцию объектов по убыванию площади фигур и вывести результат на экран.
 */
abstract class Figures
{
	abstract public function getArea();
}

 class Rectangle extends Figures{
     private $a,$b;

 	function __construct($aInp,$bInp)
   	{
        $this->a = $aInp;
        $this->b = $bInp;
    }

     function getArea()
	 {
	 	if(is_numeric($this->a)>0 && is_numeric($this->b)>0) {
            return $this->a * $this->b;
		}
	 	else
	 		return 'Ошибка в размерах фигуры';
	 }
 }

 class Circle extends Figures {
     private $a;
     const PI =3.14;

	 function __construct($aInp)
     {
     	$this->a = $aInp;
     }

	 function getArea()
	 {
	 	if(is_numeric($this->a)>0)
	 		return pow($this->a,2) * self::PI;
	 	else
            return 'Ошибка в размерах фигуры';
	 }
 }

 class Triangle extends Figures{
     private $a,$b,$c,$p;

     function __construct($aInp,$bInp,$cInp)
     {
         $this->a = $aInp;
         $this->b = $bInp;
         $this->c = $cInp;
     }

	 function getArea()
	 {
         if(is_numeric($this->a)>0 && is_numeric($this->b)>0 && is_numeric($this->c)>0) {
         	$this->p=($this->a + $this->b + $this->c) / 2;
            return sqrt($this->p*($this->p-$this->a)*($this->p-$this->b)*($this->p-$this->c));
         }
         else
             return 'Ошибка в размерах фигуры';
	 }
 }

abstract class SquareAbstract{
	public function score($data){
        $resArr=array();
		foreach ($data as $key=>$val) {
			switch ($data[$key]['type']) {
				case 'circle':
                    $resArr[]= new Circle($data[$key]['radius']);
                    break;
				case 'rectangle':
                    $resArr[]=new Rectangle($data[$key]['a'],$data[$key]['b']);
					break;
				case 'triangle':
                    $resArr[]=new Triangle($data[$key]['a'],$data[$key]['b'],$data[$key]['c']);
					break;
			}
		}
	return $resArr;
	}
}
class Square extends SquareAbstract{}

$json = file_get_contents('figures.json');
$data = json_decode($json, true);

if(!empty($data)) {
	$square = new Square();
    $result = $square->score($data);

    if(!empty($result)) {
		usort($result, function ($a, $b){
            if ($a->getArea() == $b->getArea()) {
                return 0;
            }
            return ($a->getArea() > $b->getArea()) ? -1 : 1;
		});

        foreach ($result as $obj) {
            echo 'Фигура : '. get_class($obj) . ", S = " . $obj->getArea() . "<br>";
        }
    } else {
        echo 'Параметр type всего массива указан неверно';
	}
}
else{
	    echo 'пустой массив';
	}
?>
