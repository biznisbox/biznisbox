describe('Convert quote', () => {
    it('should convert quote to invoice', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="quote_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/quotes/')
        cy.wait(1000)
        cy.get('button[id="convert_quote_to_invoice_button"').click()
        cy.wait(1000)
        cy.url().should('include', '/invoices/')
    })
})
