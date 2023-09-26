describe('List partners', () => {
    it('should list partners', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners')
        cy.get('div[id="header"]').should('contain', 'Partners')
        cy.get('div[id="partners_table"] table tbody tr').should('have.length.greaterThan', 0)
    })

    it('should check if new partner button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners')
        cy.get('div[id="header"] a[href="/partners/new"]').should('be.visible')
    })

    it('should check if new partner button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners')
        cy.get('div[id="header"] a[href="/partners/new"]').click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/partners/new')
    })
})
