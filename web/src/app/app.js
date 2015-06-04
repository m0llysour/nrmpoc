angular.module( 'NewsRoomMananger_POC', [
  'templates-app',
  'templates-common',
  'NewsRoomMananger_POC.list',
  //'NewsRoomMananger_POC.about',
  'ui.router',
  'restangular'
])

.config( function myAppConfig ( $stateProvider, $urlRouterProvider, RestangularProvider ) {
  $urlRouterProvider.otherwise( '/list' );
  RestangularProvider.setBaseUrl('http://www.thomas-bayer.com/sqlrest');

})

.run( function run () {
})

.controller( 'AppCtrl', function AppCtrl ( $scope, $location, Restangular) {
  $scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams){

    //console.log(Restangular.all('clients').getList());
    if ( angular.isDefined( toState.data.pageTitle ) ) {
      $scope.pageTitle = toState.data.pageTitle + ' | POC' ;
    }
  });
})

;

