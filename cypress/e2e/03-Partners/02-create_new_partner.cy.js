import { fa, faker } from '@faker-js/faker'
describe('Create new partner', () => {
    it('should create new partner', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/partners/new')
        cy.get('input[id="name_input"]').type(faker.company.name())
        cy.get('div[id="select_partner_type"] div').eq(2).click()
        cy.get('div[id="select_partner_entity_type"] div').eq(0).click()
        cy.get('input[id="vat_number_input"]').type(faker.datatype.number({ min: 100000000, max: 999999999 }))
        cy.get('div[id="select_partner_currency"]').click()
        cy.get('ul[id="select_partner_currency_list"] li').eq(0).click()
        cy.get('div[id="select_partner_size"]').click()
        cy.get('ul[id="select_partner_size_list"] li').eq(2).click()
        cy.get('input[id="partner_website_input"]').type(faker.internet.url())
        cy.get('div[id="select_partner_industry"]').click()
        cy.get('ul[id="select_partner_industry_list"] li')
            .eq(faker.datatype.number({ min: 0, max: 10 }))
            .click()

        // Address
        for (let i = 0; i < 3; i++) {
            cy.get('div[id="addresses_table_section"] button').eq(0).click()
            cy.get(`div[id="addresses_table_section"] div[id="type_${i}"]`).click()
            cy.get(`ul[id="type_${i}_list"] li`)
                .eq(faker.datatype.number({ min: 0, max: 3 }))
                .click()
            cy.get(`div[id="addresses_table_section"] input[id="address_${i}"]`).type(faker.address.streetAddress())
            cy.get(`div[id="addresses_table_section"] input[id="city_${i}"]`).type(faker.address.city())
            cy.get(`div[id="addresses_table_section"] input[id="zip_${i}"]`).type(faker.address.zipCode())
            cy.get(`div[id="addresses_table_section"] div[id="country_${i}"]`).click()
            cy.get(`ul[id="country_${i}_list"] li`)
                .eq(faker.datatype.number({ min: 0, max: 100 }))
                .click()
            cy.get(`div[id="addresses_table_section"] input[id="notes_${i}"]`).type(faker.lorem.sentence())
        }

        // Contact
        for (let i = 0; i < 3; i++) {
            cy.get('div[id="contacts_table_section"] button').eq(0).click()
            cy.get(`div[id="contacts_table_section"] input[id="name_${i}"]`).type(faker.name.firstName())
            cy.get(`div[id="contacts_table_section"] input[id="function_${i}"]`).type(faker.name.jobTitle())
            cy.get(`div[id="contacts_table_section"] input[id="email_${i}"]`).type(faker.internet.email())
            cy.get(`div[id="contacts_table_section"] input[id="phone_number_${i}"]`).type(faker.phone.number())
            cy.get(`div[id="contacts_table_section"] input[id="mobile_number_${i}"]`).type(faker.phone.number())
            cy.get(`div[id="contacts_table_section"] input[id="fax_number_${i}"]`).type(faker.phone.number())
            cy.get(`div[id="contacts_table_section"] input[id="notes_${i}"]`).type(faker.lorem.sentence())
        }
        cy.get('div[id="function_buttons"] button[id="save_button"]').click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/partners')
    })
})
