app = angular.module('myApp', ['angularUtils.directives.dirPagination'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
});

app.controller('CallListCtrl',
    ['$scope', '$http','$filter', '$sce',
    function($scope, $http, $filter, $sce){

        var _this = this;
        var orderBy = $filter('orderBy');

        $scope.CallListCtrl = this;

        //data
        angular.extend(this, {
            	isLoaded	: false,
	    	isAdvanceSearch	: false,
		isReverse	: true,
		pageSize	: 25,
		data_url	: '',
		field 		: 'modify_date',
		searchAdvText	: 'show advanced options',	  
		calls		: [],
		start_call_date	: '',
		end_call_date	: '',
	    columns: [
		{ 'field': 'lead_id','title': 'LeadID' },
		{ 'field': 'modify_date','title': 'CallDate' },
		{ 'field': 'status','title': 'Status' },
		{ 'field': 'user','title': 'User' },
		{ 'field': 'list_id','title': 'ListId' },
		{ 'field': 'phone_number','title': 'PhoneNumber' },
		{ 'field': 'location','title': 'Recording' }
	    ]
        });

        //methods
        angular.extend(this, {
            loadCalls : function(){
		$http.get('getCallLogs.php?call_date='+_this.start_call_date+'&end_call_date='+_this.end_call_date).then(function(data){
                	_this.calls = data.data;
		  	_this.isLoaded = true;
                });
	    },
	    changeFilterTo : function(){
				_this.searchQry = {};
				_this.isAdvanceSearch = !_this.isAdvanceSearch;
				_this.searchAdvText = _this.isAdvanceSearch ? 'hide ' : 'show ';
				_this.searchAdvText += ' advanced options';
			},
			order : function(predicate) {
				_this.isReverse = !_this.isReverse;
				_this.field = predicate;
				_this.calls = orderBy(_this.calls, predicate, _this.isReverse);
			},
			exportData : function(){
				filteredArray = $filter('filter')(_this.calls, _this.searchQry); 
				date = new Date();
				date = $filter('date')(date, 'M/d/yy@H:mm', 'UTC');
				file_name = $filter('lowercase')(_this.data_title).replace(/\s+/g, '')+"-"+date+".csv";   	
				
				alasql('SELECT lead_id, modify_date as call_date, status, user, list_id, phone_number, location as recording_link '+
						'INTO CSV("'+file_name+'",{separator: ","}) FROM ?',[filteredArray]);
			},
        });
	$scope.$watch(['CallListCtrl.start_call_date','CallListCtrl.end_call_date'],function() {
		_this.loadCalls();
	});        
}]);