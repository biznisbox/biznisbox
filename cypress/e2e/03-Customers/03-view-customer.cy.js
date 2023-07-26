describe('View customer', () => {
    it('should view customer', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="customers_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/customers/')
    })

    it('should check if edit customer button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="customers_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/customers/')
        cy.get('div[id="header"] div div button').eq(0).should('be.visible')
    })

    it('should check if edit customers button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="customers_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/customers/')
        cy.get('div[id="header"] div div button').eq(0).click()
    })
})
