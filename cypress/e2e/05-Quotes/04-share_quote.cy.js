describe('Share quote', () => {
    it('should share quote', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="quote_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/quotes/')
        cy.wait(1000)
        cy.get('button[id="share_quote_button"').click()
        cy.get('div[id="share_dialog_content"]').should('be.visible')
        cy.get('div[id="share_dialog_content"] input').type('{selectall}{ctrl+c}')
        cy.get('div[id="share_dialog_content"] button').should('be.visible')
        cy.get('div[id="share_dialog_content"] button').click()
    })
})
