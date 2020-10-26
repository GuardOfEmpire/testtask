<?php

namespace App\Validator;

/**
 * Тест валидатора массива чисел
 *
 * @group unit
 */
class ArrayOfNumericValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testIsValid_valueIsNotArray_returnFalse()
    {
        // Arrange
        $validator = new ArrayOfNumericValidator(12);
        
        // Act
        $actual = $validator->isValid();
        
        // Assert
        $this->assertFalse($actual);
    }
    
    public function testIsValid_arrayOfNumeric_returnTrue()
    {
        // Arrange
        $validator = new ArrayOfNumericValidator([12, 11, 10, 2]);
        
        // Act
        $actual = $validator->isValid();
        
        // Assert
        $this->assertTrue($actual);
    }
    
    public function testIsValid_arrayWithNonNumeric_returnFalse()
    {
        // Arrange
        $validator = new ArrayOfNumericValidator([12, 11, 'text', 2]);
        
        // Act
        $actual = $validator->isValid();
        
        // Assert
        $this->assertFalse($actual);
    }
}
