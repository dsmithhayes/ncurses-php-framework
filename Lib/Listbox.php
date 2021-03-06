<?php

class Listbox extends Window
{
    private $items      = array();
    private $firstPos   = 0;
    private $current    = 0;

    public function setItems( array $items = array() )
    {
        $this->items = $items;
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * Draw list items
     *
     * @param null $current
     *
     * @internal param int $select
     * @return void
     */
    public function drawList($current = null)
    {
        // Current more than last visible item
        if ( ( $current > ($this->firstPos + $this->getMaxY()) ) && count($this->items) > $current )
        {
            $this->firstPos = $current;
        }

        if ( $this->getMaxY() > count($this->items) )
        {
            $lastPos = count($this->items);
        }
        else
        {
            $lastPos = $this->firstPos + $this->getMaxY();
        }

//Main::_debug('c='.$current.' p='.$this->firstPos.' m='.$this->getMaxY().' i='.count($this->items));

        for ($i = $this->firstPos; $i < $lastPos  ; $i++)
        {
            $attrs = 0;
            $item = $this->items[$i];

            if ( $i === $current ) $attrs += NCURSES_A_REVERSE;
            if ( isset($item['bold'] ) && $item['bold'] ) $attrs += NCURSES_A_BOLD;
            if ( $attrs ) ncurses_wattron( $this->getWindow(), $attrs );

            ncurses_mvwaddstr($this->getWindow(), $i+1, 1, $item['title']);

            if ($attrs) ncurses_wattroff( $this->getWindow(), $attrs );
        }
    }
}
