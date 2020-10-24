<?php

namespace App\Validator;

/**
 * Контейнер для валидаторо
 */
class ValidatorContainer implements ValidatorInterface
{
    /**
     *
     * @var ValidatorInterface[]
     */
    private array $childValidators;
    
    /**
     * Возвращает установленные валидаторы
     *
     * @return ValidatorInterface[]
     */
    public function getChildValidators(): array
    {
        return $this->childValidators;
    }

    /**
     * Добавляет новый валидатор
     *
     * @param \App\Validator\ValidatorInterface $childValidators
     * @return self
     */
    public function addChildValidators(ValidatorInterface $childValidators)
    {
        $this->childValidators[] = $childValidators;

        return $this;
    }
    
    public function isValid(): bool
    {
        foreach ($this->childValidators as $validator) {
            if (!$validator->isValid()) {
                return false;
            }
        }
        
        return true;
    }
}
