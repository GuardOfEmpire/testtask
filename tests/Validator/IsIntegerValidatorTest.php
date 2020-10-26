<?php

namespace App\Validator;

/**
 * Тест валидатора на число
 *
 * @group unit
 */
class IsNumericValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testIsValid_valueIsNumeric_returnTrue()
    {
        // Arrange
        $validator = new IsNumericValidator(12);
        
        // Act
        $actual = $validator->isValid();
        
        // Assert
        $this->assertTrue($actual);
    }
    
    public function testIsValid_valueIsNotNumeric_returnFalse()
    {
        // Arrange
        $validator = new IsNumericValidator('text');
        
        // Act
        $actual = $validator->isValid();
        
        // Assert
        $this->assertFalse($actual);
    }
}
