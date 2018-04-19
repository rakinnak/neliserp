companies
 - type: company, customer, supplier

id  name            parent_id   tax_id   branch_no   is_company is_customer  is_supplier
1   JIB HQ          null        0-1005   สำนักงานใหญ่
2   JIB Branch #1   1           0-1005   001
3   JIB Branch #2   1           0-1005   002
4   OI              null        0-1009   สำนักงานใหญ่  x

locations
 - id
 - role_code   : delivery, billing, contact
 - company_id
 - name
 - address

warehouses
 - id
 - location_id
 - owner_company_id
 - name
 - address
 
docs
  type             = Selling Invoice
  base_company_id  = 1 
  company_id       = 4
  approve_user_id
  create_user_id

