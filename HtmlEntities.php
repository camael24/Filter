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
 * Class \Hoa\Filter\HtmlEntities.
 *
 * Apply a html entities filter.
 *
 * @author      Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright   Copyright © 2007-2014 Ivan Enderlin.
 * @license     New BSD License
 */

class HtmlEntities extends Generic {

    /**
     * Needed arguments.
     *
     * @var \Hoa\Filter\Generic array
     */
    protected $arguments = array(
        'quoteStyle'   => 'specify the quote style, see the PHP constants : ENT_COMPAT, ENT_QUOTES, ENT_NOQUOTES.',
        'charset'      => 'specify charset.',
        'doubleEncode' => 'specify if PHP make a double encode (true) or not (false).'
    );



    /**
     * Apply a filter.
     *
     * @access  public
     * @param   string  $string    String needed a filter.
     * @return  string
     */
    public function filter ( $string = null ) {

        if(PHP_VERSION_ID >= 50203)
            return htmlentities(
                       (string) $string,
                       $this->getFilterArgument('quoteStyle'),
                       $this->getFilterArgument('charset'),
                       $this->getFilterArgument('doubleEncode')
                   );
        else
            return htmlentities(
                       (string) $string,
                       $this->getFilterArgument('quoteStyle'),
                       $this->getFilterArgument('charset')
                   );
    }
}
