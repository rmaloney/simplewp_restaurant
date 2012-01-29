/**
 * Google Map Shortcode 
 * Version: 3.0.1
 * Author: Alain Gonzalez
 * Plugin URI: http://web-argument.com/google-map-shortcode-wordpress-plugin/
*/

var gmshc = {};

(function(){

gmshc.Map = function(settings){
		
	this.markers = settings.markers;
	this.mapContainer = document.getElementById(settings.mapContainer);
	this.zoom = (typeof settings.zoom != "undefined")? settings.zoom : 10;	
	this.type = (typeof settings.type != "undefined")? settings.type : "ROADMAP";
	this.circle = (typeof settings.circle != "undefined")? settings.circle : false;
	this.interval = (typeof settings.interval != "undefined")? settings.interval : 4000;
	this.afterTilesLoadedCallback = (typeof settings.afterTilesLoadedCallback != "undefined")? settings.afterTilesLoadedCallback : null;
	this.focusPoint = (typeof settings.focusPoint != "undefined")? settings.focusPoint : null;
	this.focusType = (typeof settings.focusType != "undefined")? settings.focusType : "open"; //center
	this.animateMarkers = (typeof settings.animateMarkers != "undefined")? settings.animateMarkers : true;
	this.afterOpenCallback = (typeof settings.afterOpenCallback != "undefined")? settings.afterOpenCallback : null;
	this.afterCircle = (typeof settings.afterCircle != "undefined")? settings.afterCircle : null;	
	
	this.map = null;
	this.markersObj = [];
	this.infowindowObj = [];
	this.intervalId = null;
	this.openItem = 0;
	this.openWindow = null;
	this.pointsNumber = this.markers.length;
	this.userInfoWindowOpen = false;
	this.disableMap = false;
	
};

gmshc.Map.prototype.init = function() {

	var firstLat = this.markers[0].lat;
	var firstLong = this.markers[0].lng;
	var firstLatLng = new google.maps.LatLng(firstLat, firstLong);
	
	this.map = new google.maps.Map(this.mapContainer, {
	  zoom: this.zoom,
	  center: firstLatLng,
	  mapTypeId: google.maps.MapTypeId[this.type]
	});
	
	var map = this.map;
	var avgLat = 0;
	var avgLng = 0;
	
	if(this.afterTilesLoadedCallback != null) {
		google.maps.event.addListener(map, 'tilesloaded', this.afterTilesLoadedCallback);	
	}
	
	for (var i = 0; i < this.pointsNumber; i++){		
   
		var location = this.markers[i];
	    var animate = (this.animateMarkers)? google.maps.Animation.DROP : null;	 
		var marker = new google.maps.Marker({
											  position: new google.maps.LatLng(location.lat, location.lng),
											  map: map,
											  icon: new google.maps.MarkerImage(location.icon),
											  animation: animate,
											  title:location.address
		  									 });
		  
		  marker.cat = location.cat;
		  this.markersObj.push(marker);

		  var infowindow = new google.maps.InfoWindow({
													  maxWidth:340,
													  content: location.info
													  });
		  this.infowindowObj.push(marker);	
													  														
		  var closure_1 = this.Bind(this.openInfoWindow(infowindow, marker));		
		  google.maps.event.addListener(marker, 'click', closure_1);
		  
		  var closure_3 = this.Bind(this.MarkerMouseOverHandler(marker));
		  google.maps.event.addListener(marker, 'mouseover', closure_3);
		  
		  var closure_5 = this.Bind(this.MarkerMouseOutHandler(marker));
		  google.maps.event.addListener(marker, 'mouseout', closure_5);
		  
		  var closure_6 = this.Bind(this.MapMouseOverHandler());
		  google.maps.event.addListener(map,'mouseover',closure_6);
		  
		  var closure_7 = this.Bind(this.MapMouseOutHandler());
		  google.maps.event.addListener(map,'mouseout',closure_7);		  		  
		  
		  // Sum up all lat/lng to calculate center all points.
		  avgLat += Number(location.lat);
		  avgLng += Number(location.lng);
    }

    // Center map.
	this.map.setCenter(new google.maps.LatLng(
		avgLat / this.pointsNumber, avgLng / this.pointsNumber));
	
    if(this.circle)  this.Play();
	if(this.focusPoint != null) {
		if (this.focusType == "center") this.Center(this.focusPoint);			
		else this.Open(this.focusPoint);		
	}
	
};

gmshc.Map.prototype.openInfoWindow = function(infoWindow, marker) {
      return function() {		  
		if (this.openWindow != null) {
			this.openWindow.close();
			this.userInfoWindowOpen = false;
		}
		if (typeof user == "undefined") user = false;	

		this.openWindow = infoWindow;		  		
		infoWindow.open(this.map, marker);
		var closure_4 = this.Bind(this.CloseInfoWindow(infoWindow));
		google.maps.event.addListener(infoWindow, 'closeclick', closure_4);
		this.userInfoWindowOpen = true;
		if(this.afterOpenCallback != null) this.afterOpenCallback(marker);
    };
};

gmshc.Map.prototype.CloseInfoWindow = function(infoWindow) {
  return function() {
	 this.userInfoWindowOpen = false;
	 this.disableMap = false;	 
  }
};

gmshc.Map.prototype.Rotate = function(){
	var visibles = this.Visibles();
	if (!visibles) {
		return;
	}
	if (this.disableMap) return;
	if (this.openItem >= this.markersObj.length) this.openItem = 0;		
	if (this.markersObj[this.openItem].getVisible()){
		if (this.focusType == "center"){
			if (this.userInfoWindowOpen) return;
			var location = this.markers[this.openItem];
			this.map.setCenter(new google.maps.LatLng(location.lat, location.lng));
			if (this.animateMarkers) {
				this.StopAllAnimations();
				this.ToggleAnimation(this.markersObj[this.openItem],"BOUNCE");
			}
		} else {
			google.maps.event.trigger(this.markersObj[this.openItem],'click');
		}
		if(this.afterCircle != null) this.afterCircle(this.markersObj[this.openItem], this.openItem);
		this.openItem ++;				
	} else {
		this.openItem ++;
		this.Rotate();
	}
		
	return;
};

gmshc.Map.prototype.Visibles = function(){
	for (var i = 0; i < this.markersObj.length; i++){
		if (this.markersObj[i].getVisible()) return true;	    
	} 
};

gmshc.Map.prototype.ToggleAnimation = function(marker,type) {
    marker.setAnimation(google.maps.Animation[type]);
};

gmshc.Map.prototype.StopAllAnimations = function(){
	for (var i = 0; i < this.markersObj.length; i++){
	    this.markersObj[i].setAnimation(null);		
	} 	
};

gmshc.Map.prototype.Play = function(){
	if (!this.circle) this.circle = true;
	if ( this.pointsNumber > 1 ) {	
		var closure_2 = this.Bind(this.Rotate);
		this.intervalId = setInterval(closure_2, this.interval);
	} else {
	    this.Open(0);
	}
};

gmshc.Map.prototype.Stop = function(){
	if (this.circle) this.circle = false;
	clearInterval(this.intervalId);
};

gmshc.Map.prototype.Open = function(point){
	if (this.disableMap) return;
	if (this.markersObj[point].getVisible())
		google.maps.event.trigger(this.markersObj[point],'click');
};

gmshc.Map.prototype.Center = function(point){
	if (this.disableMap) return;
	if (this.markersObj[point].getVisible()) {
		    if(this.openWindow != null) this.openWindow.close();
			var location = this.markers[point];
			this.map.setCenter(new google.maps.LatLng(location.lat, location.lng));
			if (this.animateMarkers) {
				this.StopAllAnimations();
				this.ToggleAnimation(this.markersObj[point],"BOUNCE");
			}			
	}
};

gmshc.Map.prototype.ShowMarkers = function(cat,display){
	if(this.openWindow != null) this.openWindow.close();
	for (var i = 0; i < this.pointsNumber; i++){
		var catList = this.markersObj[i].cat;
		var catArray = catList.split(",");
		for (var j = 0; j < catArray.length; j++){
			if (Number(catArray[j]) == cat) 
				this.markersObj[i].setVisible(display);
		}
	}
};

gmshc.Map.prototype.MarkerMouseOverHandler = function(marker) {
  return function() {
	  this.disableMap = true;
	  if (marker.getAnimation() != null) {
    	marker.setAnimation(null);
	  }
  }
};

gmshc.Map.prototype.MarkerMouseOutHandler = function(marker) {
  return function() {
	if (!this.userInfoWindowOpen) this.disableMap = false;
  }
};


gmshc.Map.prototype.MapMouseOverHandler = function(){
	return function(){	
		this.disableMap = true;
	}
}

gmshc.Map.prototype.MapMouseOutHandler = function(){
	return function(){	
		this.disableMap = false;
	}
}

gmshc.Map.prototype.Bind = function( Method ){
	var _this = this; 
	return(
		 function(){
		 return( Method.apply( _this, arguments ) );
		 }
	);
};

gmshc.addLoadEvent = function(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
		}
		else {
		window.onload = function() {
		oldonload();
		func();
		}
	}
};

})();