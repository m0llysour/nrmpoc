/**
 * Tests sit right alongside the file they are testing, which is more intuitive
 * and portable than separating `src` and `test` directories. Additionally, the
 * build process will exclude all `.spec.js` files from the build
 * automatically.
 */
describe( 'clients ', function() {
  beforeEach( module( 'NewsRoomMananger_POC.clients' ) );

  it( 'should have a dummy test', inject( function() {
    expect( true ).toBeTruthy();
  }));
  it('Should return a $scope something', function() {
     expect( true ).toBeTruthy();
  });
});

