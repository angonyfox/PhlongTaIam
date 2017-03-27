<?php
namespace PhlongTaIam;

class SingleSymbolRule
{
    function createAcceptor($tag) {
        return new SingleSymbolAcceptor();
    }
}
