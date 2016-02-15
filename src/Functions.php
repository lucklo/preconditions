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

namespace {
    function precondition() {
        return \Preconditions\Preconditions::getInstance();
    }
}

namespace Preconditions {

    /**
     * Ensures the truth of an expression involving one or more parameters to the calling method.
     *
     * @param boolean $expression               Expression to check for validity
     * @param null $errorMessageOrTemplate      Error message or message template for the exception message.
     * @param array ...$errorMessageParams      Params for Error Message Template. Internally for sprintf()
     *
     * @throws IllegalArgumentException
     */
    function check_argument($expression, $errorMessageOrTemplate = null, ...$errorMessageParams) {
        Preconditions::getInstance()->checkArgument($expression, $errorMessageOrTemplate, ...$errorMessageParams);
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
     * @throws \Preconditions\Exception\IndexOutOfBoundsException    When $index is negative or is not less than $size
     * @throws \Preconditions\Exception\IllegalArgumentException     When size is negative
     */
    function check_element_index($index, $size, $desc = "Index") {
        return Preconditions::getInstance()->checkElementIndex($index, $size, $desc);
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
     * @throws \Preconditions\Exception\NullPointerException     When $reference value is null
     */
    function check_not_null($reference, $errorMessageOrTemplate = null, ...$errorMessageParams) {
        return Preconditions::getInstance()->checkNotNull($reference, $errorMessageOrTemplate, ...$errorMessageParams);
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
     * @throws \Preconditions\Exception\IndexOutOfBoundsException    When $index is negative or is greater than $size
     * @throws \Preconditions\Exception\IllegalArgumentException     When $size is negative
     */
    function check_position_index($index, $size, $desc = "Position") {
        return Preconditions::getInstance()->checkPositionIndex($index, $size, $desc);
    }

    /**
     * Ensures that start and end specify a valid positions in an array or string of size size, and are in order.
     * A position index may range from zero to size, inclusive.
     *
     * @param int $start    User-supplied index identifying a starting position in an array or string
     * @param int $end      User-supplied index identifying a ending position in an array or string
     * @param int $size     Size of that array or string
     *
     * @throws \Preconditions\Exception\IndexOutOfBoundsException    When either $index is negative or is greater than $size, or if $end is less than $start
     * @throws \Preconditions\Exception\IllegalArgumentException     When $size is negative
     */
    function check_position_indexes($start, $end, $size) {
        Preconditions::getInstance()->checkPositionIndexes($start, $end, $size);
    }

    /**
     * Ensures the truth of an expression involving the state of the calling instance,
     * but not involving any parameters to the calling method.
     *
     * @param boolean $expression               Expression to validate
     * @param null $errorMessageOrTemplate      Error message or message template for the exception message.
     * @param array ...$errorMessageParams      Params for Error Message Template. Internally for sprintf()
     *
     * @throws \Preconditions\Exception\IllegalStateException
     */
    function check_state($expression, $errorMessageOrTemplate = null, ...$errorMessageParams) {
        Preconditions::getInstance()->checkState($expression, $errorMessageOrTemplate, ...$errorMessageParams);
    }

}

