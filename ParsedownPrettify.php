<?php

#
#
# Parsedown Extra
# https://github.com/erusev/parsedown-extra
#
# (c) Emanuil Rusev
# http://erusev.com
#
# For the full license information, view the LICENSE file that was distributed
# with this source code.
#
#

class ParsedownPrettify extends ParsedownExtra
{

    #
    # Code

    protected function identifyCodeBlock($Line)
    {
        $Block = parent::identifyCodeBlock($Line);
        if (isset($Block))
        {
            unset($Block['element']['text']['name']);
            return $Block;
        }
    }

    #
    # Fenced Code

    protected function identifyFencedCode($Line)
    {
        $Block = parent::identifyFencedCode($Line);
        if (isset($Block))
        {
            $Block['element']['attributes'] = array('class' => 'prettyprint');
            if (!isset($Block['element']['text']['attributes']))
            {
                unset($Block['element']['text']['name']);
            }
            return $Block;
        }
    }

    #
    # ~
    #

    protected function element(array $Element)
    {
        $markup = '<'.$Element['name'];

        if (isset($Element['attributes']))
        {
            foreach ($Element['attributes'] as $name => $value)
            {
                $markup .= ' '.$name.'="'.$value.'"';
            }
        }

        if (isset($Element['text']))
        {
            $markup .= '>';

            if (isset($Element['handler']))
            {
                if (isset($Element['text']['name']))
                {
                    $markup .= $this->$Element['handler']($Element['text']);
                }
                else
                {
                    $markup .= $Element['text']['text'];
                }
            }
            else
            {
                $markup .= $Element['text'];
            }

            $markup .= '</'.$Element['name'].'>';
        }
        else
        {
            $markup .= ' />';
        }

        return $markup;
    }
}
