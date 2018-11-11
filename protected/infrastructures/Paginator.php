<?php
class Paginator
{
	public $get;
    public $items_per_page;
    public $items_total;
    public $current_page;
    public $num_pages;
    public $mid_range;
    public $low;
    public $high;
    public $limit;
    public $default_ipp = 25;
    
    public $prev_page;
    public $first;
    public $prev_dot;
    public $pages;
    public $next_dot;
    public $last;
    public $next_page;

	function paginate()
	{
        $this->items_per_page = $this->default_ipp;

		if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) {
			$this->items_per_page = $this->default_ipp;
		}

		$this->num_pages = ceil($this->items_total/$this->items_per_page);
		$this->current_page = (int) $this->get; // must be numeric > 0
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($this->num_pages > $this->mid_range)
        {
			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0) {
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}

			if($this->end_range > $this->num_pages) {
				$this->start_range -= $this->end_range - $this->num_pages;
				$this->end_range = $this->num_pages;
			}

			if($this->current_page == $this->num_pages) {
				$this->start_range--;
			}

			if($this->current_page == 1) {
				$this->end_range++;
			}
			
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				//return
				if($this->range[0] > 2 And $i == $this->range[0]) {
					$this->prev_dot = true;
				}
				
				//return
				if($i==1) {
					$this->first = array('title'=>$i, 'active'=>($i == $this->current_page) ? false : true);
				}

				// loop through all pages. if first, last, or in range, display
				if($i!=1 AND in_array($i,$this->range) AND $i!=$this->num_pages) {
					//return
					$this->pages[] = array('title'=>$i, 'active'=>($i == $this->current_page) ? false : true);
				}
				
				//return
				if($i==$this->num_pages) {
					$this->last = array('title'=>$i, 'active'=>($i == $this->current_page) ? false : true);
				}

				//return
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) {
					$this->next_dot = true;
				}
			}
        }
        else {
			for($i=1;$i<=$this->num_pages;$i++) {
				//return
				$this->pages[] = array('title'=>$i, 'active'=>($i == $this->current_page) ? false : true);
			}
        }
        
        //return
        $this->prev_page = ($this->current_page != 1) ? $prev_page : null;
		$this->next_page = ($this->current_page != $this->num_pages) ? $next_page : null;


        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = ($this->current_page * $this->items_per_page)-1;
        $this->limit = " LIMIT $this->low,$this->items_per_page";
	}
}
?>