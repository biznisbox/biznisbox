describe('Download invoice', () => {
    it('should download invoice', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="invoice_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/invoices/')
        cy.wait(1000)
        cy.get('button[id="download_invoice_button"').click()
        cy.wait(5000)
        cy.verifyDownload('.pdf', { contains: true })
    })
})
