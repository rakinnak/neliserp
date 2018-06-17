    <table border="0" width="100%" cellspacing="0" cellpadding="5" class="banner">
        <tr>
            <td>
                Sale Order / ใบสั่งซื้อ
            </td>
        </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="3">
        <tr>
            <td style="text-align:left;" width="50%">
                Nelierp Company Co.Ltd.
                <br/>&nbsp; 11 May Street, Friday, 201805
            </td>
            <td style="text-align:right;">
                Document Number: <span class="doc-data">{{ $doc->name }}</span>
                <br/>Order Date: <span class="doc-data">{{ $doc->issued_at }}</span>
            </td>
        </tr>
    </table>

    <div style="font-size:10">&nbsp;</div>
    <table border="1" width="100%" cellspacing="0" cellpadding="3">
        <tr>
            <th width="50%">
                Billing to
            </th>
            <th width="50%">
                Shipping to
            </th>
        </tr>
            <tr>
            <td style="text-align:left;">
                Name: <span class="doc-data">{{ $doc->partner_name }}</span>
                <br/>&nbsp; Address: <span class="doc-data">?</span>
                <br/>&nbsp; City/Provice: <span class="doc-data">?</span>
                <br/>&nbsp; Country: <span class="doc-data">?</span>
                <hr>
                <br/>&nbsp; Attn.:
                <br/>&nbsp; Phone:
            </td>
            <td style="text-align:left;">
                Name: <span class="doc-data">{{ $doc->partner_name }}</span>
                <br/>&nbsp; Address: <span class="doc-data">?</span>
                <br/>&nbsp; City/Provice: <span class="doc-data">?</span>
                <br/>&nbsp; Country: <span class="doc-data">?</span>
                <hr>
                <br/>&nbsp; Attn.:
                <br/>&nbsp; Phone:
            </td>
        </tr>
    </table>

    <div style="font-size:10">&nbsp;</div>

    <table border="1" width="100%" cellspacing="0" cellpadding="3">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Item Code</th>
                <th width="50%"><B>Description</B></th>
                <th width="10%">Quantity</th>
                <th width="10%">Unit Price</th>
                <th width="10%">Price (--Currency--)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doc->doc_items as $doc_item)
            <tr>
                <td width="5%" style="text-align:center">{{ $doc_item->line_number }}</td>
                <td width="15%">{{ $doc_item->item_code }}</td>
                <td width="50%">{{ $doc_item->item_name }}</td>
                <td width="10%" style="text-align:right">{{ $doc_item->quantity }}</td>
                <td width="10%" style="text-align:right">{{ $doc_item->unit_price }}</td>
                <td width="10%" style="text-align:right">{{ $doc_item->unit_price * $doc_item->quantity}}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="5" style="text-align:right;">Sub Total</th>
                <td style="text-align:right">{{ $doc->sub_total }}</td>
            </tr>
            <tr>
                <th colspan="5" style="text-align:right">VAT 7%</th>
                <td style="text-align:right">{{ $doc->vat }}</td>
            </tr>
            <tr>
                <th colspan="5" style="text-align:right">Total</th>
                <td style="text-align:right">{{ $doc->total }}</td>
            </tr>
        </tbody>
    </table>
    <div style="font-size:1">&nbsp;</div>
    <div>
        Remark: Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi earum aliquam, illum maxime nulla quae quia distinctio adipisci nemo accusantium odio eum dolore dolorum dolor molestiae ipsam totam. Odit, cumque?
    </div>
    <div>
        Remark: Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi earum aliquam, illum maxime nulla quae quia distinctio adipisci nemo accusantium odio eum dolore dolorum dolor molestiae ipsam totam. Odit, cumque? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis nobis reiciendis commodi provident nesciunt ex minima maiores, delectus dolorem, accusantium similique quas ut nihil a cum. Nulla ea est molestiae! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique eligendi, suscipit reprehenderit doloremque culpa vitae veniam dolor non, eius deleniti, quod placeat natus ab quaerat quam distinctio temporibus fugiat nobis? Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci id aperiam libero harum quibusdam vero nulla sed atque eveniet molestiae, cupiditate totam deleniti repudiandae illum voluptatibus excepturi labore in deserunt! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores facere hic, consequuntur non maiores culpa excepturi deserunt officia libero aut consequatur accusamus animi unde modi est, magnam sit cupiditate? Consectetur. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque officiis itaque ullam molestias ut, repellendus voluptatum dolorem tempore eum! Eos minus sequi veniam nam nihil? Iusto accusantium aut corrupti similique! Lorem ipsum dolor sit amet consectetur adipisicing elit. Non nulla vel cum nemo, earum corrupti dolore neque sapiente deleniti optio ducimus consequuntur quam, quisquam, eveniet quos ipsum error atque est. Lorem ipsum dolor sit amet consectetur adipisicing elit. Et pariatur esse ipsa molestiae cupiditate reiciendis mollitia itaque unde! Tempore laudantium esse at, voluptates sunt praesentium quam eum corporis distinctio consectetur. Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita distinctio quae soluta est? Fugiat perspiciatis eaque illo laborum non rerum modi delectus corrupti. Necessitatibus ipsam officia dignissimos unde nisi facere? Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore quaerat quibusdam, laboriosam cum nihil quis quidem nisi sint, error, illum magni. Maiores natus veniam harum magnam repudiandae blanditiis itaque consequatur! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellendus iusto odio illum, commodi nulla tenetur totam nobis quasi velit. Veritatis sunt non accusantium distinctio esse magnam magni reprehenderit pariatur eos.
    </div>
