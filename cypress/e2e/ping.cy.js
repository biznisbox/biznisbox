it('Check if the server is up', () => {
    cy.request('/api').its('status').should('equal', 200)
})
