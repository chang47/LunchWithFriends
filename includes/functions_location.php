<?php
function find_restuarants($loc_lat, $loc_lng, $q)
{
	global $yelp;
	return $yelp->request('search?term=' . urlencode($q) . '&ll=' . urlencode($loc_lat) . ',' . urlencode($loc_lng) . '&sort=2')->businesses;
}
