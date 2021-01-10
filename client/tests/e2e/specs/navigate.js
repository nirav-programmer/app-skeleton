describe('Navigate on the home page', () => {
  it('Display the login form', () => {
    cy.visit('/');
    cy.contains('input', 'Save');
  });
});
