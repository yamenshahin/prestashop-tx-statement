{extends file="page.tpl"}
{block name="content"}
    <nav data-depth="3" class="breadcrumb hidden-sm-down">
        <ol>
            <li>
                <a href="/"><span>Home</span></a>
            </li>
            <li>
                <a href="/my-account"><span>Your account</span></a>
            </li>
            <li>
                <span>Statements</span>
            </li>
        </ol>
    </nav>
    <header class="page-header">
        <h1>Statements</h1>
    </header>

    <section id="content" class="page-content">



        <aside id="notifications">
            <div class="container">



            </div>
        </aside>



        <h6>Here are the orders you've placed since your account was created.</h6>

            <table class="table table-striped table-bordered table-labeled hidden-sm-down">
                <thead class="thead-default">
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total Order</th>
                        <th>Total Commission</th>
                        <th>Total Shipping Rate</th>
                        <th>Total Payable</th>
                        <th>Status</th>
                        <th>Transaction</th>
                        <th>Commission Invoice</th>
                        <th>Statement Invoice</th>
                    </tr>
                </thead>
                <tbody>

                    {foreach $taxStatements as $taxStatement}
                        <tr>
                            <th scope="row">{$taxStatement['id']}</th>
                            <td>{$taxStatement['date']}</td>
                            <td>SAR{$taxStatement['total_order']}</td>
                            <td>SAR{$taxStatement['total_commission']}</td>
                            <td>SAR0.0</td>
                            <td>SAR{$taxStatement['total_payable']}</td>
                            <td>

                                <span class="label label-pill dark" 
                {if $taxStatement['status'] === 'Ready for payment'}
                                        style="background-color:#3498D8" 
                {else} style="background-color:#47b4af"

                {/if}>{$taxStatement['status']}</span>

                            </td>
                            <td class="text-sm-center">
                                <a href="#"><i class="material-icons"></i></a>
                            </td>
                            <td class="text-sm-center">
                                <a href="#"><i class="material-icons"></i></a>
                            </td>
                            <td class="text-sm-center">
                                <a href="#"><i class="material-icons"></i></a>
                            </td>
                        </tr>
                    {/foreach}

                </tbody>
            </table>
        </section>
    {/block}