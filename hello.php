<?php
// include ('../vendor/autoload.php');
include 'vendor/autoload.php';

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class Employee{

    public $id;
    public $name;
    public $salary;
    public $applying;

    public function __construct($id, $name, $salary, $applying){
        $this->id = $id;
        $this->name = $name;
        $this->salary = $salary;
        $this->applying = $applying;
    }

    public function getWorkTime(){
        $applying = $this->applying;
        $tmp = explode('.', $applying);
        $old = date('Y')-$tmp[2];
        echo 'Time of working: ' . $old;
        return $old;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank());
        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('name', new Assert\Length(array(
            'min'        => 1,
            'max'        => 10,
        )));
        $metadata->addPropertyConstraint('salary', new Assert\NotBlank());
        $metadata->addPropertyConstraint('salary', new Assert\Positive());
        $metadata->addPropertyConstraint('applying', new Assert\NotBlank());
        $metadata->addPropertyConstraint('applying', new Assert\Date());
    }
}


class Department
{
    public string $name;
    public $employee = [];

    public function __construct(string $name, $empl){
        $this->name = $name;
        $this->employee = array_merge($empl, $this->employee);
    }

    public function sumSalary(){
        $sumsalary = 0;
        foreach($this->employee as $empl){
            $sumsalary += $empl->salary;
        }
        return $sumsalary;
    }
    
}


$employee1 = new Employee(1, 'Seregy', 550, '01.12.1980');
$employee2 = new Employee(2, 'Evgeny', 450, '01.02.2000');
$employee3 = new Employee(3, 'Natalia', 50, '20.12.2020');
$employee4 = new Employee(4, 'Ivan', 50, '15.01.2022');
$employee5 = new Employee(5, 'Joe', 500, '13.11.2003');
$employee1->getWorkTime();

$department1 = new Department('MOS Department', [$employee1, $employee2, $employee3]);
$department2 = new Department('St-Pet Department', [$employee4, $employee5]);

echo ("<br>");
echo ("<br>");

echo ('Sum of salary in department1: ');
echo $department1->sumSalary();
echo ("<br>");
echo ('Sum of salary in department2: ');
echo $department2->sumSalary();
echo ("<br>");
echo ("<br>");




$depSalaries = array($department1->sumSalary(), $department2->sumSalary());
$maxSalaryDep = max($depSalaries);
echo ('Max value of salary in all departments: ');
echo ($maxSalaryDep);
echo ("<br>");
$minSalaryDep = min($depSalaries);
echo ('Min value of salary in all departments: ');
echo ($minSalaryDep);
echo ("<br>");



$allDepartments = [$department1, $department2];
$allEmpl = [];
for ($i=0; $i < count($allDepartments); $i++)
{
    $maxDep = count($allDepartments[$i]->employee);
    array_push($allEmpl, $maxDep);
}

echo "q";

$maxEmpl = max($allEmpl); //max qty emploee
echo ($maxEmpl);
echo ("<br>");



for ($i=0; $i <= count($allDepartments); $i++)
{
    $maxDep = count($allDepartments[$i]->employee);
    $maxSal = $allDepartments[$i]->sumSalary();
    if ($maxEmpl == $maxDep && $maxSal == $maxSalaryDep) {
        // $max = $allDepartments[$i]->sumSalary();
        echo ($allDepartments[$i]->name);
        echo ("<br>");
        echo ($maxSalaryDep);
    }
}
