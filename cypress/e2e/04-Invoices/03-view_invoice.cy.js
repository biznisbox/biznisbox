describe('View invoice', () => {
    it('should view invoice', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="invoice_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/invoices/')
    })

    it('should check if edit invoice button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="invoice_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/invoices/')
        cy.get('div[id="header"] div div button').eq(0).should('be.visible')
    })

    it('should check if edit invoice button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="invoice_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/invoices/')
        cy.get('div[id="header"] div div button').eq(0).click()
    })
})
