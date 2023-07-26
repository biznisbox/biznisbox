describe('Delete customer', () => {
    it('should delete customer', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="customers_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/customers/')
        cy.get('div[id="header"] div div button').eq(1).click()
        cy.get('div.p-dialog div.p-dialog-footer button').eq(1).click()
        cy.url().should('include', '/customers')
    })
})
