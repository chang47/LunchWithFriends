<?php
function find_restuarants($loc_lat, $loc_lgn, $q)
{
	global $yelp;
	return $yelp->request('search?term=' . urlencode($q) . '&ll=' . urlencode($loc_lat) . ',' . urlencode($loc_lgn) . '&sort=2');
}
