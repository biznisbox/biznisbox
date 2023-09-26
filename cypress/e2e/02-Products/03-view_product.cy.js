describe('View product', () => {
    it('should view product', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="products_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/products/')
    })

    it('should check if edit product button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="products_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/products/')
        cy.get('div[id="header"] div div button').eq(0).should('be.visible')
    })

    it('should check if edit product button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="products_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/products/')
        cy.get('div[id="header"] div div button').eq(0).click()
    })
})
