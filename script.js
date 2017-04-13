angular.module('myApp', ['ngMaterial', 'chart.js'])

.controller('MyCtrl', function($scope, $mdDialog, $http) {

  $scope.phpCall = function() {
    $.ajax({
      url: 'pdf.php',
      type: 'PUT',
      // data: "parameter=some_parameter",
      success: function(data) {
        console.log(data);
      }
    });
  }

  $scope.openFbLink = function(fbLink) {
    window.open(fbLink);
  }

  $scope.days = [];
  for (var i = 0; i < 30; i++) {
    $scope.days.push(i);
  };

  $scope.selected = 20;

  $scope.sorts = ['All', 'Positive', 'Negative'];
  $scope.selectedSort = 'All';

  $scope.dateTransform = function(date) {
    var givenDate = new Date(date);
    var today = new Date();
    var ms = moment(today, "DD/MM/YYYY HH:mm:ss").diff(moment(givenDate, "DD/MM/YYYY HH:mm:ss"));
    var dateStr = moment.duration(ms);

    var s = '';
    if (dateStr._data.years > 0) {
      var s = dateStr._data.years + ' years';
    } else if (dateStr._data.months > 0) {
      var s = dateStr._data.months + ' months';
    } else if (dateStr._data.days > 0) {
      var s = dateStr._data.days + ' days';
    } else if (dateStr._data.hours > 0) {
      var s = dateStr._data.hours + ' hours';
    } else if (dateStr._data.minutes > 0) {
      var s = dateStr._data.minutes + ' minutes';
    } else {
      var s = dateStr._data.seconds + ' seconds';
    }
    // var s = dateStr._data.days +'Days '+dateStr._data.hours +'Hours '+dateStr._data.minutes +'Minutes '+dateStr._data.seconds +'Seconds';
    return s;
  }
  $http.get("details.json").then(function(response) {
    $scope.mydata = response.data;
    $scope.positiveLabels = [];
    $scope.positiveData = [
      [],
      []
    ];

    $scope.colours = ["#289ad5", "#ff0e6a"];

    $scope.chartArray = response.data.overview.sentiment_over_time.positive;
    $scope.chartArray2 = response.data.overview.sentiment_over_time.negative;
    for (var i = 0; i < $scope.chartArray.length; i++) {
      $scope.positiveLabels[i] = $scope.chartArray[i].time;
    }
    for (var i = 0; i < $scope.chartArray.length; i++) {
      $scope.positiveData[0][i] = $scope.chartArray[i].count;
    }
    for (var i = 0; i < $scope.chartArray2.length; i++) {
      $scope.positiveData[1][i] = $scope.chartArray2[i].count;
    }

    $scope.datasetOverride = [{
      yAxisID: 'y-axis-1'
    }, {
      yAxisID: 'y-axis-2'
    }];

    $scope.series = ['Series A', 'Series B'];

    $scope.positiveOptions = {
      scales: {
        yAxes: [{
          id: 'y-axis-1',
          type: 'linear',
          display: true,
          position: 'left'
        }, {
          id: 'y-axis-2',
          type: 'linear',
          display: true,
          position: 'right'
        }]
      }
    };

    $scope.barArray = $scope.mydata.overview.source_wise_stats;

    $scope.labels = ['Facebook'];
    $scope.barSeries = ['Series A'];

    $scope.data = [
      [$scope.barArray.facebook.positive_count, 0],
      [$scope.barArray.facebook.negative_count, 0]
    ];
    // $scope.positiveOptions = response.data.overview.sentiment_over_time.positive;
    // $scope.positiveLabels = response.data.overview.sentiment_over_time.positive;
    console.log($scope.mydata);
  });
});
