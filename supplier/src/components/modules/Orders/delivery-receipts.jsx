import React from 'react';
import ReactPaginate from 'react-paginate';
import CurrencyFormat from 'react-currency-format';
import { PDFDownloadLink, View, Page, Font, Text, Document, StyleSheet } from '@react-pdf/renderer';


// const DeliveryReceipts = () => (
//   <div>
//     <PDFDownloadLink document={<Sample />} fileName="somename.pdf">
//       {({ blob, url, loading, error }) => (loading ? 'Loading document...' : 'Download now!')}
//     </PDFDownloadLink>
//   </div>
// );

const fethcAddress=(address)=>{
  console.log(address);
    const format = address.split('<br />');
    return format;
  }
const sno=0;
const DeliveryReceipts = (props) => (
  <Document>
    <Page style={styles.body}>
      <View style={styles.header} fixed>
        <View style={{display: 'flex', flexDirection: 'row'}}>
            <View style={styles.headerContainer}>
                {props.supplierAddress != undefined && props.supplierAddress != null && fethcAddress(props.supplierAddress).map((address, i)=>{
                      return(<Text style={i==0 ? {fontSize:'14', fontWeight:'bold'}:['styles.headerAddress']} key={address}>{address}</Text>)
                    })}
            </View>
            <View style={{textAlign:'center', flex: '1', display: 'flex', color:'#383838'}}>
                <Text>Delivery Receipts</Text>
            </View>  
            <View style={styles.drContainer}>
                <Text>{props.dr_number}</Text>
                <Text>{props.dr_date}</Text>
            </View>  
          </View>
      </View>
      <View style={styles.shipRow}>
        <View style={styles.shipTo}>
          <Text style={[styles.addressTitle, { fontWeight: 'bold', fontSize:'12', marginBottom:16 }]}>Ship To:</Text>
          {props.deliveryAddress != undefined && props.deliveryAddress != null && fethcAddress(props.deliveryAddress).map((address)=>{
                        return(<Text style={styles.address} key={address}>{address}</Text>)
                      })}
        </View>
      </View>
      <View style={styles.orderDetails}>
        <View style={styles.data}>
          <Text style={styles.dataTitle}>Order</Text>
          <Text style={styles.date}>#{props.id_order}</Text>
        </View>
        <View style={styles.data}>
          <Text style={styles.dataTitle}>PO Number</Text>
          <Text style={styles.date}>{props.po_number!=undefined ? props.po_number :""} </Text>
        </View>
        <View style={styles.data}>
          <Text style={styles.dataTitle}>Order Date</Text>
          <Text style={styles.date}>{props.order_date}</Text>
        </View>
      </View>
      <View style={[styles.orderDetails,styles.productDetailsHeader]}>
        <View style={styles.col1}>
          <Text style={styles.dataTitle}>S.NO</Text>
        </View>
        <View style={styles.col1}>
          <Text style={styles.dataTitle}>Reference</Text>
        </View>
        <View style={styles.col2}>
          <Text style={styles.dataTitle}>Product</Text>
        </View>
        <View style={styles.col1}>
          <Text style={[styles.dataTitle, styles.dataQty]}>Qty</Text>
        </View>
      </View>
      <View style={{borderColor:'#ccc', borderLeftWidth:1, borderRightWidth:1}}>
      {props.products != undefined && props.products.length >0 && props.products.map((product, i)=>{
        let sno = sno+1;
        return(
            <View style={styles.productDetails}>
              <View style={styles.data}>
                <Text style={styles.col1}>{i+1}</Text>
              </View>
              <View style={styles.col1}>
                <Text style={styles.date}>{product.product_reference}</Text>
              </View>
              <View style={styles.col2}>
                <Text style={styles.date}>{product.product_name}</Text>
              </View>
              <View style={styles.col1}>
                <Text style={[styles.date, styles.dataQty]}>{product.product_quantity}</Text>
              </View>
            </View>
          )
      })}
      </View>
      <Text style={styles.text}>
        This is computer generated delivery receipt.
      </Text>
      <View style={[styles.footer, styles.pageNumber]}>
        <View style={styles.data}>
          <Text style={styles.dataTitle}>Signature of Receiver</Text>
          <Text style={styles.date}></Text>
        </View>
        <View style={styles.data}>
          <Text style={styles.date}></Text>
        </View>
        <View style={styles.data}>
          <Text style={styles.dataTitle}>For kobster E-Shop pvt ltd</Text>
          <Text style={styles.date}></Text>
        </View>
      </View>
      <Text style={styles.pageNumber} render={({ pageNumber, totalPages }) => (
        `${pageNumber} / ${totalPages}`
      )} fixed />
    </Page>
  </Document>
);

Font.register(
  'https://fonts.gstatic.com/s/oswald/v13/Y_TKV6o8WovbUd3m_X9aAA.ttf',
  { family: 'Oswald' },
);

const styles = StyleSheet.create({
  body: {
    paddingTop: 35,
    paddingBottom: 65,
    paddingHorizontal: 35,
  },
  title: {
    fontSize: 24,
    textAlign: 'center',
    fontFamily: 'Oswald'
  },
  author: {
    fontSize: 12,
    textAlign: 'center',
    marginBottom: 40,
  },
  subtitle: {
    fontSize: 18,
    margin: 12,
    fontFamily: 'Oswald'
  },
  text: {
    margin: 12,
    fontSize: 6,
    textAlign: 'justify',
    fontFamily: 'Oswald',
    color: '#fff'
  },
  image: {
    marginVertical: 15,
    marginHorizontal: 100,
  },
  header: {
    fontSize: 12,
    marginBottom: 20,
    textAlign: 'left',
  },
  headerContainer:{flex: '1', display: 'flex', flexDirection: 'column', fontSize: '10'},
  headerAddress:{fontWeight: 'normal',fontSize:'6',marginBottom:'2'},
  drContainer:{flex: '1', display: 'flex', flexDirection: 'column','alignItems':'center',fontSize: '10', textAlign:'center'},
  shipRow:{display:'flex', flexDirection:'row', marginBottom: 8},
  shipTo:{display: 'flex', flexDirection: 'column', maxWidth:'300'},
  addressTitle:{fontWeight: 'bold',fontSize:'10',marginBottom:'4'},
  address:{fontWeight: 'normal',fontSize:'10',marginBottom:'2'},
  orderDetails:{display:'flex', flexDirection:'row',borderWidth: '1', borderColor: '#ccc',padding: '6'},
  productDetails:{display:'flex', flexDirection:'row', padding: '6', borderBottomColor: '#ccc', borderBottomWidth: 1},
  data:{flex:1, display: 'flex', flexDirection: 'column',justifyContent:'space-between', fontSize:'10'},
  dataTitle:{fontWeight: 'bold', fontSize:'10',padding: '2'},
  dataQty:{textAlign:'center'},
  date:{padding: '2'},
  col1:{flex:1,fontSize:'10'},
  col2:{flex:5,fontSize:'10'},
  productDetailsHeader:{marginTop:'10'},
  footer:{display:'flex', flexDirection:'row',padding: '6'},
  pageNumber: {
    position: 'absolute',
    fontSize: 12,
    bottom: 30,
    left: 0,
    right: 0,
    textAlign: 'center',
    color: 'grey',
  },
});

// ReactPDF.render(<Quixote />);

export default DeliveryReceipts;