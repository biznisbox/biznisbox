describe('Delete invoice', () => {
    it('should delete invoice', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="invoice_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/invoices/')
        cy.wait(1000)
        cy.get('button[id="delete_invoice_button"').click()
        cy.get('div.p-dialog div.p-dialog-footer button').eq(1).click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/invoices')
    })
})
