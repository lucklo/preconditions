<?php
/**
 * Copyright 2016 Łukasz Łoboda <lukasz.w.loboda@gmail.com>
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/

namespace Preconditions;

use Preconditions\Exception\IllegalArgumentException,
    Preconditions\Exception\IllegalStateException,
    Preconditions\Exception\IndexOutOfBoundsException,
    Preconditions\Exception\NullPointerException;

class Preconditions
{
    /**
     * @var Preconditions
     */
    static private $instance;

    /**
     * Singleton patter used mostly in Precondition
     * functions in this package.
     *
     * @return Preconditions
     */
    static function getInstance()
    {
        if (empty(self::$instance)) {
           self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *
     *
     * @param null $errorMessageOrTemplate      Error message or message template for the exception message.
     * @param array $errorMessageParams         Params for Error Message Template. Internally for sprintf()
     * @return string
     */
    private function getErrorMessage($errorMessageOrTemplate = null, $errorMessageParams)
    {
        $errorMessage = $errorMessageOrTemplate;
        if(!empty($errorMessageParams)) {
            $errorMessage = sprintf($errorMessageOrTemplate, ...$errorMessageParams);
        }

        return $errorMessage;
    }

    /**
     * Ensures the truth of an expression involving one or more parameters to the calling method.
     *
     * @param boolean $expression
     * @param null $errorMessageOrTemplate      Error message or message template for the exception message.
     * @param array ...$errorMessageParams      Params for Error Message Template. Internally for sprintf()
     * @throws IllegalArgumentException
     */
    public function checkArgument($expression, $errorMessageOrTemplate = null, ...$errorMessageParams)
    {
        if (!$expression) {
            throw new IllegalArgumentException(
                $this->getErrorMessage($errorMessageOrTemplate, $errorMessageParams)
            );
        }
    }

    /**
     * Ensures the truth of an expression involving the state of the calling instance,
     * but not involving any parameters to the calling method.
     *
     * @param boolean $expression               Expression to validate
     * @param null $errorMessageOrTemplate      Error message or message template for the exception message.
     * @param array ...$errorMessageParams      Params for Error Message Template. Internally for sprintf()
     *
     * @throws IllegalStateException
     */
    public function checkState($expression, $errorMessageOrTemplate = null, ...$errorMessageParams)
    {
        if (!$expression) {
           throw new IllegalStateException(
               $this->getErrorMessage($errorMessageOrTemplate, $errorMessageParams)
           );
        }
    }

    /**
     * Ensures that an object reference passed as a parameter to the calling method is not null.
     *
     * @param mixed $reference                  Reference to check for null
     * @param null $errorMessageOrTemplate      Error message or message template for the exception message.
     * @param array ...$errorMessageParams      Params for Error Message Template. Internally for sprintf()
     *
     * @return mixed    Non-null reference that was validated
     *
     * @throws NullPointerException     When $reference value is null
     */
    public function checkNotNull($reference, $errorMessageOrTemplate = null, ...$errorMessageParams)
    {
        if (is_null($reference)) {
            throw new NullPointerException(
                $this->getErrorMessage($errorMessageOrTemplate, $errorMessageParams)
            );
        }

        return $reference;
    }

    /**
     * Ensures that index specifies a valid element in an array or string of size size.
     * An element index may range from zero, inclusive, to size, exclusive.
     *
     * @param int $index    User-supplied index identifying an element of an array or string
     * @param int $size     Size of that array or string
     * @param string $desc  Text to use to describe this index in an error message
     *
     * @return int  Value of index
     *
     * @throws IndexOutOfBoundsException    When $index is negative or is not less than $size
     * @throws IllegalArgumentException     When size is negative
     */
    public function checkElement($index, $size, $desc = "Index")
    {
        if ($index < 0 || $index >= $size) {
            throw new IndexOutOfBoundsException(
                $this->getBadElementIndex($index, $size, $desc)
            );
        }
        return $index;
    }

    /**
     * Generate Error Message for checkElement predicate.
     *
     * @param int $index    User-supplied index identifying an element of an array or string
     * @param int $size     Size of that array or string
     * @param string $desc  Text to use to describe this index in an error message
     *
     * @return string   Error message
     *
     * @throws IllegalArgumentException     When size is negative
     */
    protected function getBadElementIndex($index, $size, $desc)
    {
        if ($index < 0) {
            return sprintf("%s (%s) must not be negative", $desc, $index);
        } elseif ($size < 0) {
            throw new IllegalArgumentException("Negative size: " . $size);
        } else {
            return sprintf("%s (%s) must be less than size (%s)", $desc, $index, $size);
        }
    }


    /**
     * Ensures that index specifies a valid position in an array or string of size size.
     * A position index may range from zero to size, inclusive.
     *
     * @param int $index    User-supplied index identifying an element of an array or string
     * @param int $size     Size of that array or string
     * @param string $desc  Text to use to describe this index in an error message
     *
     * @return int  Validated Index
     *
     * @throws IndexOutOfBoundsException    When $index is negative or is greater than $size
     * @throws IllegalArgumentException     When $size is negative
     */
    public function checkPositionIndex($index, $size, $desc = "Position")
    {
        if ($index < 0 || $index > $size) {
            throw new IndexOutOfBoundsException(
                $this->getBadPositionIndex($index, $size, $desc)
            );
        }

        return $index;
    }

    /**
     * Generate Error Message for checkPositionIndex and checkPositionIndexes predicates.
     *
     * @param int $index    User-supplied index identifying an element of an array or string
     * @param int $size     Size of that array or string
     * @param string $desc  Text to use to describe this index in an error message
     *
     * @return string   Error Message
     *
     * @throws IllegalArgumentException     When $size is negative
     */
    protected function getBadPositionIndex($index, $size, $desc)
    {
        if ($index < 0) {
            return sprintf("%s (%s) must not be negative", $desc, $index);
        } elseif ($size < 0) {
            throw new IllegalArgumentException("Negative size: ".$size);
        } else {
            return sprintf("%s (%s) must not be greater than size (%s)", $desc, $index, $size);
        }
    }

    /**
     * Ensures that start and end specify a valid positions in an array or string of size size, and are in order.
     * A position index may range from zero to size, inclusive.
     *
     * @param int $start    User-supplied index identifying a starting position in an array or string
     * @param int $end      User-supplied index identifying a ending position in an array or string
     * @param int $size     Size of that array or string
     *
     * @throws IndexOutOfBoundsException    When either $index is negative or is greater than $size, or if $end is less than $start
     * @throws IllegalArgumentException     When $size is negative
     */
    public function checkPositionIndexes($start, $end, $size)
    {
        if ($start < 0 || $end < $start || $end > $size) {
            throw new IndexOutOfBoundsException(
                $this->getBadPositionIndexes($start, $end, $size)
            );
        }
    }

    /**
     * Generate Error Message for checkPositionIndexes predicate.
     *
     * @param int $start    User-supplied index identifying a starting position in an array or string
     * @param int $end      User-supplied index identifying a ending position in an array or string
     * @param int $size     Size of that array or string
     *
     * @return string   Error Message
     *
     * @throws IllegalArgumentException     When $size is negative
     */
    protected function getBadPositionIndexes($start, $end, $size)
    {
        if ($start < 0 || $start > $size) {
            return $this->getBadPositionIndex($start, $size, "Start Index");
        }

        if ($end < 0 || $end > $size) {
            return $this->getBadPositionIndex($end, $size, "End Index");
        }

        return sprintf("End Index (%s) must not be less than start index (%s)", $end, $start);
    }

}
