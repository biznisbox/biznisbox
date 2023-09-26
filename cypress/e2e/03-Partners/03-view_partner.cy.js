describe('View partner', () => {
    it('should view partner', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners')
        cy.get('div[id="partners_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/partners/')
    })

    it('should check if edit partner button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners')
        cy.get('div[id="partners_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/partners/')
        cy.get('div[id="header"] div div button').eq(0).should('be.visible')
    })

    it('should check if edit partner button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners')
        cy.get('div[id="partners_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/partners/')
        cy.get('div[id="header"] div div button').eq(0).click()
    })
})
