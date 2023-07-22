describe('Login', () => {
    it('should login', () => {
        cy.visit('/auth/login')
        cy.get('input[id="email"]').type(Cypress.env('USERNAME'))
        cy.get('input[id="password"]').type(Cypress.env('PASSWORD'))
        cy.get('button[type="submit"]').click()
        cy.url().should('not.include', '/auth/login')
    })

    it('should not login', () => {
        cy.visit('/auth/login')
        cy.get('input[id="email"]').type(Cypress.env('USERNAME'))
        cy.get('input[id="password"]').type('wrongpassword')
        cy.get('button[type="submit"]').click()
        cy.url().should('include', '/auth/login')
    })
})
