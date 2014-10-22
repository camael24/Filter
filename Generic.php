<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2014, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Filter;


/**
 * Class \Hoa\Filter\Generic.
 *
 * The abstract class of all filters. Allow to manage the arguments of filters.
 *
 * @author      Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright © 2007-2014 Ivan Enderlin.
 * @license     New BSD License
 */

abstract class Generic {

    /**
     * Needed arguments.
     *
     * @var \Hoa\Filter\Generic array
     */
    protected $arguments     = array();

    /**
     * The filter arguments.
     *
     * @var \Hoa\Filter\Generic array
     */
    private $filterArguments = array();



    /**
     * Set the needed arguments.
     *
     * @access  public
     * @param   array   $args    The arguments of the filter.
     * @return  void
     * @throw   \Hoa\Filter\Exception
     */
    public function __construct ( Array $args = array() ) {

        $this->setFilterArguments($args);
    }

    /**
     * Check arguments of the filter.
     *
     * @access  protected
     * @return  bool
     * @throw   \Hoa\Filter\Exception
     */
    protected function _checkArguments ( ) {

        $needed = array();
        $args   = $this->getFilterArguments();

        foreach($this->getArguments() as $name => $label)
            if(!isset($args[$name]))
                $needed[] = $name . ' : ' . $label;

        if(empty($needed))
            return true;

        $message = get_class($this) . ' needs parameters :' . "\n  - " .
                   implode("\n" . '  - ', $needed);

        throw new \Hoa\Filter\Exception($message, 0);

        return false;
    }

    /**
     * Set arguments of the filter.
     *
     * @access  private
     * @param   array   $args    Arguments of the filter.
     * @return  array
     * @throw   \Hoa\Filter\Exception
     */
    private function setFilterArguments ( Array $args = array() ) {

        $old                   = $this->filterArguments;
        $this->filterArguments = $args;

        $this->_checkArguments();

        return $old;
    }

    /**
     * Get an argument of the filter.
     *
     * @access  public
     * @param   string  $arg    The argument name.
     * @return  mixed
     * @throw   \Hoa\Filter\Exception
     */
    public function getFilterArgument ( $name ) {

        if(   null !== $this->filterArguments[$name]
           && !isset($this->filterArguments[$name]))
            throw new \Hoa\Filter\Exception(
                'The argument %s does not exit.', 1, $name);

        return $this->filterArguments[$name];
    }

    /**
     * Get arguments of the filter.
     *
     * @access  public
     * @return  array
     */
    public function getFilterArguments ( ) {

        return $this->filterArguments;
    }

    /**
     * Get needed arguments.
     *
     * @access  protected
     * @return  array
     */
    protected function getArguments ( ) {

        return $this->arguments;
    }

    /**
     * Force to implement filter method.
     *
     * @access  public
     * @param   string  $data    Data to filter.
     * @return  bool
     */
    abstract public function filter ( $string = null );
}
