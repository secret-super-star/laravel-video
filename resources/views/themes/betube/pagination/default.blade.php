@php
    $page = (int)app('request')->input('page') == 0 ? 1 : app('request')->input('page');
@endphp
@if($series->lastPage() > 1)

<?php
	function get_paging_info($tot_rows,$pp,$curr_page)
    {
        $pages = ceil($tot_rows / $pp); // calc pages

        $data = array(); // start out array
        $data['si']        = ($curr_page * $pp) - $pp; // what row to start at
        $data['pages']     = $pages;                   // add the pages
        $data['curr_page'] = $curr_page;               // Whats the current page

        return $data; //return the paging data

    }
?>


<?php $count = $series->total() ?>

<!-- Call our function from above -->
<?php $paging_info = get_paging_info($count,$series->perPage(),$page); ?>

<div class="pagination">
<p>
    <!-- If the current page is more than 1, show the First and Previous links -->
	<?php if($paging_info['curr_page'] > 1) : ?>

    <a href='{{$series->previousPageUrl()}}' class="prev page-numbers" title='Page <?php echo ($paging_info['curr_page'] - 1); ?>'>« Previous</a>
	<?php endif; ?>



	<?php
	//setup starting point

	//$max is equal to number of links shown
	$max = 7;
	if($paging_info['curr_page'] < $max)
		$sp = 1;
  elseif($paging_info['curr_page'] >= ($paging_info['pages'] - floor($max / 2)) )
		$sp = $paging_info['pages'] - $max + 1;
  elseif($paging_info['curr_page'] >= $max)
		$sp = $paging_info['curr_page']  - floor($max/2);
	?>

<!-- If the current page >= $max then show link to 1st page -->
	<?php if($paging_info['curr_page'] >= $max) : ?>

    <a href='' title='Page 1'>1</a>
    <span>...</span>

	<?php endif; ?>

<!-- Loop though max number of pages shown and show links either side equal to $max / 2 -->
	<?php for($i = $sp; $i <= ($sp + $max -1);$i++) : ?>

	<?php
	if($i > $paging_info['pages'])
		continue;
	?>

	<?php if($paging_info['curr_page'] == $i) : ?>

    <span class="page-numbers current" ><?php echo $i; ?></span>

	<?php else : ?>

    <a href='?page={{$i}}' title='Page <?php echo $i; ?>'><?php echo $i; ?></a>

	<?php endif; ?>

	<?php endfor; ?>


<!-- If the current page is less than say the last page minus $max pages divided by 2-->
	<?php if($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>

    <span>...</span>
    <a href='?page={{$series->lastPage()}}' title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a>
	<?php endif; ?>

<!-- Show last two pages if we're not near them -->
	<?php if($paging_info['curr_page'] < $paging_info['pages']) : ?>

    <a class="next page-numbers" href='{{$series->nextPageUrl()}}' title='Page <?php echo ($paging_info['curr_page'] + 1); ?>'>Next »</a>



	<?php endif; ?>
</p>
@endif
</div>