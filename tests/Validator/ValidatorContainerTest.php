<?php

namespace App\Validator;

/**
 * Тест для контейнера валидатора
 * @group unit
 */
class ValidatorContainerTest extends \PHPUnit\Framework\TestCase
{
    public function testGetChildValidators_childValidatorsNotSeted_returnEmptyArray()
    {
        // Arrange
        $validator = new ValidatorContainer();
        
        // Act
        $actual = $validator->getChildValidators();
        
        // Assert
        $this->assertEquals([], $actual);
    }
    
    public function testAddChildValidators_addChildValidators_validatorsSeted()
    {
        // Arrange
        $validator = new ValidatorContainer();
        $expected = [
            new IsNumericValidator(3),
            new IsNumericValidator(30),
        ];
        
        // Act
        $validator->addChildValidator(new IsNumericValidator(3));
        $validator->addChildValidator(new IsNumericValidator(30));
        $actual = $validator->getChildValidators();
        
        // Assert
        $this->assertEquals($expected, $actual);
    }
    
    public function testIsValid_someValidators_endInFirstNotValid()
    {
        // Arrange
        $validator = new ValidatorContainer();
        
        // Act
        $validator->addChildValidator($this->makeFakeExecutedValidator());
        $validator->addChildValidator($this->makeFakeExecutedValidator(false));
        $validator->addChildValidator($this->makeFakeNotExecutedValidator());
        $validator->addChildValidator($this->makeFakeNotExecutedValidator());

        $validator->isValid();
    }
    
    private function makeFakeExecutedValidator($isValidResult = true)
    {
        $fake = $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $fake->expects($this->once())->method('isValid')->willReturn($isValidResult);
        
        return $fake;
    }
    
    private function makeFakeNotExecutedValidator()
    {
        $fake = $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $fake->expects($this->never())->method('isValid');
        
        return $fake;
    }
}
