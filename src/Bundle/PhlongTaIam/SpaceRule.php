<?php
namespace PhlongTaIam;

class SpaceRule
{
    function createAcceptor($tag) {
        if (array_key_exists("SPACE_RULE", $tag))
            return null;
        return new SpaceRuleAcceptor();
    }
}
