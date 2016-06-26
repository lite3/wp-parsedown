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

class ParsedownPrettify extends Parsedown
// class ParsedownPrettify extends ParsedownExtra
{

    #
    # Fenced Code

    protected function blockFencedCode($Line)
    {
        $Block = parent::blockFencedCode($Line);
        if (isset($Block))
        {
            # add class prettyprint 
            $Block['element']['text']['attributes'] = array('class' => 'prettyprint');
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
                if ($value === null)
                {
                    continue;
                }

                $markup .= ' '.$name.'="'.$value.'"';
            }
        }

        if (isset($Element['text']))
        {
            $markup .= '>';

            if (isset($Element['handler']))
            {
                # FencedCode or CodeBlock
                # don't print code tag
                if ($Element['name'] != 'pre')
                {
                    $markup .= $this->{$Element['handler']}($Element['text']);
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
