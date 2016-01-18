<?php namespace App\Geodata;


trait LocatableTrait {

	/**
     * Connect to Zipcode
     */
    function zipcode()
   	{
      	return $this->belongsTo('App\Geodata\Zipcode');
   	}

	/**
     * Get City 
	 *	
	 * @return App\Geodata\City 
     */
	function city() 
	{
		return $this->zipcode?$this->zipcode->city():null;
	}

	/**
     * Get District
	 *	
	 * @return App\Geodata\District 
     */
	function district() 
	{
		return $this->zipcode?$this->zipcode->district():null;
	}

	/**
     * shortname to idenitfy a location 
	 * generated from zipcode and first part of streetname
	 *
	 * @return string|null  shortname
     */
	function getShortnameAttribute() 
	{

		// Extract zipcode from address
		$parts = explode(" ",$this->address2);

		if ( count($parts)> 0 && is_numeric($parts[0]) ) {

			$shortname = $parts[0];
			$parts = explode(" ",$this->address1);
			if ( count($parts) > 0 ) {
				$shortname .= ', '.$parts[0];
				return $shortname;
			}

		}
		return null;
	}

    private function geocodeKey() {
		return  md5($this->geocodeString());
	}

    private function geocodeString() {
		return  $this->address1 . ', ' . $this->address2. ', Deutschland';
	}

	/**
	 * Get more detailed geocode from OSM
     */	 
	function geocode() {

		$geocode = $this->geocodeString();

		// Do not geocode twice
	    $geocoded = $this->geocodeKey();	
		if ($this->geocoded == $geocoded) {
			
			return true;
			
		} else {
		
			$geocoder = new \Geocoder\Geocoder();
			$adapter = new \Geocoder\HttpAdapter\CurlHttpAdapter();
			
			$geocoder->registerProviders(array(
				//new \Geocoder\Provider\GoogleMapsProvider($adapter),
				new \Geocoder\Provider\OpenStreetMapProvider($adapter)
			));
			
			
			try {
				$geotools = new \League\Geotools\Geotools();
				$cache = new \League\Geotools\Cache\MongoDB();
				$results = $geotools->batch($geocoder)
								->setCache($cache)
								->geocode([$geocode])->parallel();
			} 
			
			catch( Exception $ex) {
				return false;
			}
			
			if (count($results) > 0) {
				if ($results[0]->getExceptionMessage()) {
					return false;   			
				} 
				
				else {
				
					$this->lat = $results[0]->getLatitude();
        			$this->lng = $results[0]->getLongitude();
					$this->geosource = 'OSM';
					$this->geocoded = $geocoded;
					return true;
				}
			} 
			
			else {
				return false; 
			}
		
		}
		
    }

	/**
     * Overwrite Address2 Setter 
	 * to geocode the locatable model
	 * 
     */
	function setAddress2Attribute($address2) 
	{

		$this->attributes['address2'] = $address2;

		$parts = explode(" ",$address2);
		if ( count($parts)> 0 && is_numeric($parts[0]) ) {

			$zipcode = Zipcode::where('zipcode','=',$parts[0])->first();
		
			if ($zipcode instanceOf Zipcode) {

				// connect to  Zipcode 
				$this->zipcode_id =  $zipcode->id;
				
				// Try to geocode 
				if (!$this->geocode()) {

					$geocoded = $this->geocodeKey();

					// use district lat lng if available
					if ($zipcode->district) {
				
						$this->lat = $zipcode->district->lat;
						$this->lng = $zipcode->district->lng;
						$this->geosource = 'ZIPD';
						$this->geocoded = $geocoded;

					} 

					// use city lat lng if available
					else if ($zipcode->city) {

						$this->lat = $zipcode->city->lat;
						$this->lng = $zipcode->city->lng;
						$this->geosource = 'ZIPC';
						$this->geocoded = $geocoded;

					}
	
				}
	
			}

		}

	}

}
