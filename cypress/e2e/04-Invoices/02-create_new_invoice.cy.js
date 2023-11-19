import { faker } from '@faker-js/faker'
describe('Create new invoice', () => {
    it('should create new invoice', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices/new')
        cy.get('div[id="customer_input"]').click()
        cy.get('ul[id="customer_input_list"] li').eq(0).click()
        cy.get('div[id="payer_input"]').click()
        cy.get('ul[id="payer_input_list"] li').eq(0).click()
        cy.get('span[id="date_input"] input').click()
        cy.get('span[id="date_input"] input')
            .invoke('attr', 'aria-controls')
            .then((id) => {
                cy.get(`div[id="${id}"]`).click()
                cy.get(`div[id="${id}"]`).find('table tbody tr td').eq(0).click()
            })
        cy.get('span[id="due_date_input"] input').click()
        cy.get('span[id="due_date_input"] input')
            .invoke('attr', 'aria-controls')
            .then((id) => {
                cy.get(`div[id="${id}"]`).click()
                cy.get(`div[id="${id}"]`).find('table tbody tr td').eq(0).click()
            })

        cy.get('div[id="item_section"] button').eq(1).click() // remove default item
        // Invoice items
        for (let i = 0; i < 3; i++) {
            cy.get('div[id="item_section"] button[id="add_item_button"]').click()
            cy.get(`div[id="item_section"] div[id="product_select_${i}"]`).click()
            cy.get(`ul[id="product_select_${i}_list"] li`).eq(0).click()
            cy.get(`div[id="item_section"] textarea[id="description_input_${i}"]`).type(faker.lorem.sentence())
            cy.get(`div[id="item_section"] span[id="quantity_input_${i}"] input`).type(faker.datatype.number({ min: 1, max: 10 }))
        }
        cy.get('span[id="discount_input"] input').type(faker.datatype.number({ min: 1, max: 50 }))
        cy.get('div[id="function_buttons"] button[id="save_button"]').click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/invoices')
    })
})
