angular.module( 'NewsRoomMananger_POC', [
  'templates-app',
  'templates-common',
  'NewsRoomMananger_POC.clients',
  //'NewsRoomMananger_POC.about',
  'ui.router',
  'restangular'
])

.config( function myAppConfig ( $stateProvider, $urlRouterProvider, RestangularProvider ) {
  $urlRouterProvider.otherwise( '/clients/list' );
  RestangularProvider.setBaseUrl('http://192.168.59.103/');

})

.run( function run () {

})

.controller( 'AppCtrl', function AppCtrl ( $scope, $location, Restangular) {
  $scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams){
    if ( angular.isDefined( toState.data.pageTitle ) ) {
      $scope.pageTitle = toState.data.pageTitle + ' | POC' ;
    }
  });
})

;

