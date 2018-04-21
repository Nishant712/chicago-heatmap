<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>Chicago Taxi DropOff Location Heatmap</title>
    <style>
      html { height: 100% }
      body { 
          height: 100%; 
          font-family:sans-serif; 
          
      }
      #map-canvas { 
          margin-top: 1%;
          width: 100%;
          height: 90%; 
      }
      
      h2 {
          margin-top: 0;
      }
      
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkcY9do9bcPzM-W3CfHgowjhaCT9i_uuc&callback=initMap"
  type="text/javascript"></script>
    <script src="./js/heatmap.js"></script>
    <script src="./js/gmaps-heatmap.js"></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>
  </head>
  <body>
    <div class="page_header">
        <div class="map_title"><h2>Chicago Taxi DropOff Locations Heatmap</h2></div>
        <div class="options">
            <input type="radio" name="year" value="2013" onclick="chooseYear()" checked> 2013
            <input type="radio" name="year" value="2014" onclick="chooseYear()"> 2014
            <input type="radio" name="year" value="2015" onclick="chooseYear()"> 2015
            <input type="radio" name="year" value="2016" onclick="chooseYear()"> 2016
            <input type="radio" name="year" value="2017" onclick="chooseYear()"> 2017
        </div>
    </div>
    
    <div id="map-canvas"></div>
    
    
    <script>
        showYear(2013);
        function chooseYear() {
            var year = document.querySelector('input[name = "year"]:checked').value;
            console.log(year);
            showYear(parseInt(year));
        }
        function showYear(year) {
            var fileName = "";
            if(year == 2013) {
                fileName = "./counts_2013.csv"
            } else if(year == 2014) {
              fileName = "./counts_2014.csv"
            } else if(year == 2015) {
                  fileName = "./counts_2015.csv"
            } else if(year == 2016) {
                  fileName = "./counts_2016.csv"
            } else if(year == 2017) {
                  fileName = "./counts_2017.csv"
            }
            d3.csv(fileName, function(d) {
              return {
                lat : parseFloat(d.lat),
                lng : parseFloat(d.lng),
                count : parseInt(d.count)
              };
            }, function(data) {
              
              console.log(data[0]);
              parse_data(data);
            });
        }
        
      function parse_data(dataset) {
        var parsed_data = [];
        for(var i = 0; i < dataset.length; i++) {
          parsed_data.push(dataset[i]);
        }
        console.log(parsed_data);
        // map center
        var myLatlng = new google.maps.LatLng(41.8781, -87.6298);
        // map options,
        var myOptions = {
          zoom: 11,
          center: myLatlng
        };
        // standard map
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        // heatmap layer
        heatmap = new HeatmapOverlay(map, 
          {
            // radius should be small ONLY if scaleRadius is true (or small radius is intended)
            "radius": 20,
            "maxOpacity": 1, 
            // scales the radius based on map zoom
            "scaleRadius": false, 
            // if set to false the heatmap uses the global maximum for colorization
            // if activated: uses the data maximum within the current map boundaries 
            //   (there will always be a red spot with useLocalExtremas true)
            "useLocalExtrema": false,
            // which field name in your data represents the latitude - default "lat"
            latField: 'lat',
            // which field name in your data represents the longitude - default "lng"
            lngField: 'lng',
            // which field name in your data represents the data value - default "value"
            valueField: 'count'
          }
        );

        var testData = {
          max: 10000,
           data: parsed_data
        };

        heatmap.setData(testData);
      }
        
        
        
        // console.log(parsed_data);
        
        // console.log(parsed_data);
        // var testData = {
        //   max: 8,
        //    data: [{lat: 24.6408, lng:46.7728, count: 3},{lat: 50.75, lng:-1.55, count: 1},{lat: 52.6333, lng:1.75, count: 1},{lat: 48.15, lng:9.4667, count: 1},{lat: 52.35, lng:4.9167, count: 2},{lat: 60.8, lng:11.1, count: 1},{lat: 43.561, lng:-116.214, count: 1},{lat: 47.5036, lng:-94.685, count: 1},{lat: 42.1818, lng:-71.1962, count: 1},{lat: 42.0477, lng:-74.1227, count: 1},{lat: 40.0326, lng:-75.719, count: 1},{lat: 40.7128, lng:-73.2962, count: 2},{lat: 27.9003, lng:-82.3024, count: 1},{lat: 38.2085, lng:-85.6918, count: 1},{lat: 46.8159, lng:-100.706, count: 1},{lat: 30.5449, lng:-90.8083, count: 1},{lat: 44.735, lng:-89.61, count: 1},{lat: 41.4201, lng:-75.6485, count: 2},{lat: 39.4209, lng:-74.4977, count: 1},{lat: 39.7437, lng:-104.979, count: 1},{lat: 39.5593, lng:-105.006, count: 1},{lat: 45.2673, lng:-93.0196, count: 1},{lat: 41.1215, lng:-89.4635, count: 1},{lat: 43.4314, lng:-83.9784, count: 1},{lat: 43.7279, lng:-86.284, count: 1},{lat: 40.7168, lng:-73.9861, count: 1},{lat: 47.7294, lng:-116.757, count: 1},{lat: 47.7294, lng:-116.757, count: 2},{lat: 35.5498, lng:-118.917, count: 1},{lat: 34.1568, lng:-118.523, count: 1},{lat: 39.501, lng:-87.3919, count: 3},{lat: 33.5586, lng:-112.095, count: 1},{lat: 38.757, lng:-77.1487, count: 1},{lat: 33.223, lng:-117.107, count: 1},{lat: 30.2316, lng:-85.502, count: 1},{lat: 39.1703, lng:-75.5456, count: 8},{lat: 30.0041, lng:-95.2984, count: 2},{lat: 29.7755, lng:-95.4152, count: 1},{lat: 41.8014, lng:-87.6005, count: 1},{lat: 37.8754, lng:-121.687, count: 7},{lat: 38.4493, lng:-122.709, count: 1},{lat: 40.5494, lng:-89.6252, count: 1},{lat: 42.6105, lng:-71.2306, count: 1},{lat: 40.0973, lng:-85.671, count: 1},{lat: 40.3987, lng:-86.8642, count: 1},{lat: 40.4224, lng:-86.8031, count: 4},{lat: 47.2166, lng:-122.451, count: 1},{lat: 32.2369, lng:-110.956, count: 1},{lat: 41.3969, lng:-87.3274, count: 2},{lat: 41.7364, lng:-89.7043, count: 2},{lat: 42.3425, lng:-71.0677, count: 1},{lat: 33.8042, lng:-83.8893, count: 1},{lat: 36.6859, lng:-121.629, count: 2},{lat: 41.0957, lng:-80.5052, count: 1},{lat: 46.8841, lng:-123.995, count: 1},{lat: 40.2851, lng:-75.9523, count: 2},{lat: 42.4235, lng:-85.3992, count: 1},{lat: 39.7437, lng:-104.979, count: 2},{lat: 25.6586, lng:-80.3568, count: 7},{lat: 33.0975, lng:-80.1753, count: 1},{lat: 25.7615, lng:-80.2939, count: 1},{lat: 26.3739, lng:-80.1468, count: 1},{lat: 37.6454, lng:-84.8171, count: 1},{lat: 34.2321, lng:-77.8835, count: 1},{lat: 34.6774, lng:-82.928, count: 1},{lat: 39.9744, lng:-86.0779, count: 1},{lat: 35.6784, lng:-97.4944, count: 2},{lat: 33.5547, lng:-84.1872, count: 1},{lat: 27.2498, lng:-80.3797, count: 1},{lat: 41.4789, lng:-81.6473, count: 1},{lat: 41.813, lng:-87.7134, count: 1},{lat: 41.8917, lng:-87.9359, count: 1},{lat: 35.0911, lng:-89.651, count: 1},{lat: 32.6102, lng:-117.03, count: 1},{lat: 41.758, lng:-72.7444, count: 1},{lat: 39.8062, lng:-86.1407, count: 1},{lat: 41.872, lng:-88.1662, count: 1},{lat: 34.1404, lng:-81.3369, count: 1},{lat: 46.15, lng:-60.1667, count: 1},{lat: 36.0679, lng:-86.7194, count: 1},{lat: 43.45, lng:-80.5, count: 1},{lat: 44.3833, lng:-79.7, count: 1},{lat: 45.4167, lng:-75.7, count: 2},{lat: 43.75, lng:-79.2, count: 2},{lat: 45.2667, lng:-66.0667, count: 3},{lat: 42.9833, lng:-81.25, count: 2},{lat: 44.25, lng:-79.4667, count: 3},{lat: 45.2667, lng:-66.0667, count: 2},{lat: 34.3667, lng:-118.478, count: 3},{lat: 42.734, lng:-87.8211, count: 1},{lat: 39.9738, lng:-86.1765, count: 1},{lat: 33.7438, lng:-117.866, count: 1},{lat: 37.5741, lng:-122.321, count: 1},{lat: 42.2843, lng:-85.2293, count: 1},{lat: 34.6574, lng:-92.5295, count: 1},{lat: 41.4881, lng:-87.4424, count: 1},{lat: 25.72, lng:-80.2707, count: 1},{lat: 34.5873, lng:-118.245, count: 1},{lat: 35.8278, lng:-78.6421, count: 1}]
        // };
        // heatmap.setData(testData);
</script>
  </body>
</html>