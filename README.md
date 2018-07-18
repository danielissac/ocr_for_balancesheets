# ocr_for_balancesheets
Using Microsoft Azure and Google's Vision API JSON will be created for the given balance sheet. Feed the JSON to Php parser. It will classify the balance sheets contents based on the assets,liabilities,equity and calculates the creditworthiness of the business.

How to execute:

1) Select a balancesheet that you want to parse
2) Get json format for the selected balancesheet using both Microsoft Azure and Google cloud vision API
3) Feed the json files to the respective parser
4) Run the azure_parser.php finally the contents of the balancesheet will be classified

Sample output:

The output for the sample_balance_sheet.png would be like this,

The final output of the entire program 
The accuracy of output might be vary depends on the balancesheet clarity
new_assets_array
Array ( ) 
new_current_assets_array
Array ( [cash] => 2100 [pettycash] => 100 [temporaryinvestments] => 10000 [accountsreceivablenet] => 40500 [supplies] => 3800 [prepaidinsurance] => 1500 [totalcurrentassets] => 89000 [landimprovements] => 6500 [buildings] => 180000 [propplantampequipnet] => 337000 ) 
new_non_current_assets_array
Array ( [tradenames] => 200000 ) 
new_liabilities_array
Array ( ) 
new_current_liabilities_array
Array ( [notespayable] => 5000 [accountsreceivablenet] => 35900 [warrantyliability] => 1100 [unearnedrevenues] => 1500 ) 
new_non_current_liabilites_array
Array ( [notespayable] => 20000 ) 
new_equity_array
Array ( [commonstock] => 110000 [retainedearnings] => 220000 [accumothercomprehensiveincome] => 9000 [totalstockholdersequity] => 289000 [totalliabilities] => 770000 )
