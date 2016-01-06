<?php

namespace AppBundle\Tool;

class Char
{
    const ARROW_UP = "\e[A";
    const ARROW_DOWN = "\e[B";
    const ARROW_RIGHT = "\e[C";
    const ARROW_LEFT = "\e[D";

    const ARROW_UP_SHIFT = "\eOA";
    const ARROW_DOWN_SHIFT = "\eOB";
    const ARROW_RIGHT_SHIFT = "\eOC";
    const ARROW_LEFT_SHIFT = "\eOD";

    const ARROW_UP_ALT = "\e\eA";
    const ARROW_DOWN_ALT = "\e\eB";
    const ARROW_RIGHT_ALT = "\e\eC";
    const ARROW_LEFT_ALT = "\e\eD";

    const ENTER = "\n";
    const ESCAPE = "\e";
    const SPACE = " ";
}