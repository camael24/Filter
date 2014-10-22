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
 * Class \Hoa\Filter.
 *
 * Build a stack of filter.
 *
 * @author      Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright © 2007-2014 Ivan Enderlin.
 * @license     New BSD License
 */

class Filter extends Generic {

    /**
     * Collection of filters.
     *
     * @var \Hoa\Filter array
     */
    protected $filters = array();


    /**
     * Add a filter.
     *
     * @access  public
     * @param   mixed   $filters    The filters.
     * @return  void
     * @throw   \Hoa\Filter\Exception
     */
    public function addFilter ( $filters ) {

        if(!is_array($filters))
            $filters = array($filters => array());

        foreach($filters as $filter => $arguments) {

            if(is_int($filter)) {

                $filter    = $arguments;
                $arguments = array();
            }

            if(is_array($filter)) {

                $arguments = current($filter);
                $filter    = key($filter);
            }

            if(!is_array($arguments))
                $arguments = array($arguments);

            $arguments = array($arguments);

            //$filter = \Hoa\Factory::get('Filter', $filter, $arguments);

            if(!($filter instanceof Hoa\Filter\Generic))
                throw new \Hoa\Filter\Exception(
                    'The filter %s does not extend \Hoa\Filter\Generic.',
                    0, get_class($filter));

            if($this->filterExists(get_class($filter)))
                throw new \Hoa\Filter\Exception(
                    'The filter %s already exists.',
                    1, get_class($filter));

            $this->filters[get_class($filter)] = $filter;
        }
    }

    /**
     * Check if a filter already exists or not.
     *
     * @access  public
     * @param   string  $filter    The filter.
     * @return  bool
     */
    public function filterExists ( $filter ) {

        return isset($this->filters[$filter]);
    }

    /**
     * Get filters.
     *
     * @access  protected
     * @return  array
     */
    protected function getFilters ( ) {

        return $this->filters;
    }

    /**
     * Check if a data is valid.
     *
     * @access  public
     * @param   string  $string    The string to filter.
     * @return  bool
     */
    public function filter ( $string = null ) {

        foreach($this->getFilters() as $name => $filter)
            $string = $filter->filter($string);

        return $string;
    }
}
