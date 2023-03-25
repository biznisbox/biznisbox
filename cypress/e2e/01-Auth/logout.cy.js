describe('Logout', () => {
    it('should logout', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/auth/logout')
        cy.url().should('include', '/auth/login')
    })
})
