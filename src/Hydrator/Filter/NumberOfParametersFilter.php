<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright      Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Hydrator\Filter;

use Hydrator\Context\ExtractionContext;
use Hydrator\Exception\InvalidArgumentException;
use ReflectionException;
use ReflectionMethod;

/**
 * This filter accepts any method that have a given number of accepted parameters
 */
final class NumberOfParametersFilter implements FilterInterface
{
    /**
     * The number of parameters being accepted
     *
     * @var int
     */
    private $numberOfParameters;

    /**
     * @param int $numberOfParameters Number of accepted parameters
     */
    public function __construct($numberOfParameters = 0)
    {
        $this->numberOfParameters = (int) $numberOfParameters;
    }

    /**
     * {@inheritDoc}
     */
    public function accept($property, ExtractionContext $context = null)
    {
        try {
            $reflectionMethod = new ReflectionMethod($context->object, $property);
        } catch (ReflectionException $exception) {
            throw new InvalidArgumentException(sprintf('Method "%s" does not exist', $property), 0, $exception);
        }

        return $reflectionMethod->getNumberOfParameters() === $this->numberOfParameters;
    }
}
