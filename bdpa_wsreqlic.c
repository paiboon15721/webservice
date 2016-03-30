/***********************************************************************************
Create By : Norrapong Huarakkit (QCM)
Create Date : 12/1/58
Create Desc : Business Services (Web services) กลาง สำหรับ ระบบ E-DOPA
Create Version : 58.01C
***********************************************************************************/
/***********************************************************************************
Modify By : Norrapong Huarakkit (QCM)
Modify Date : 29/5/58
Modify Desc : ปรับปรุงโปรแกรมให้รองรับทั้ง .NET Client และ Web Services Client
Modify Version : 58.02C
***********************************************************************************/
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/time.h>
#include <time.h>
#include <atmi.h>
#include <stdarg.h>
#include <ctype.h>
#include <userlog.h>
#include <assert.h>
#include "log.h"

#define BUFSZ	1024*500
#define	UL 	1
#define	EL 	0

void	substr(char *,char *,int ,int );
void	*rtrim(char *);

int _iconv_(char *fromcharset , char *tocharset, char *inbuf, char *outbuf);

int g_logLevel;
/*******************************************************************************/
int   searchPite(char *tmpIn)
{
   int  ptr=0;
   if (tmpIn[ptr] == '\0') return(-1);
   while (tmpIn[ptr] != '\0')
   {
      if (tmpIn[ptr] != '|') ptr++;
      else break;
   }
   return(ptr);
}         /* searchPite */
/******************************************************************************/
void getStrInPite(char *tmpIn, char *tmpOut){
	int iRet=0;
	char tmpBuf[BUFSZ] = "";
	
	iRet = searchPite(tmpIn);
    substr(tmpOut, tmpIn, 0, iRet);
	substr(tmpBuf, tmpIn, iRet+1, (strlen(tmpIn) - iRet));
	strcpy(tmpIn,tmpBuf);
	tmpBuf[0] = '\0';

}     /* getStrInPite */
/******************************************************************************/
int tpsvrinit(int argc,char *argv[])
{
extern char	*optarg;
int     c;

	g_logLevel = 0;
	setLineLength(5120); //กำหนดความยาวการเขียนข้อมูลต่อบรรทัด
	setLogPrefix("/aps/tuxedo/logs/bdpa_wsreqlic"); 
	writeLog(UL,"Services bdpa_wsreqlic initialize!!");

	while ( (c=getopt(argc, argv, "d:")) != EOF ) {
		switch ( c ) {
			case 'd' :	g_logLevel = atoi(optarg);
			                        setLogLevel(g_logLevel);
					break;
		}
	}
	return 0;
}
/********************************************************************************************************************/
void bdpa_wsreqlic(TPSVCINFO *rqst)
{
char	*rcvbuf;
char	*rqst_buf;
char	*tmpbuf;
int	ret = 0;
int 	iconv = 0;
long	rcvlen;
char	servicesName[30] = "";
char	chkServicesName[30] = "";
char	chkServicesName2[30] = "";
char	chkCode[5] = "";

	writeLog(UL,"Data From Client rqst->data[%s]",rqst->data);
	
	/* alocate buffer use with TUXEDO */
	if((rcvbuf = (char *) tpalloc("STRING", NULL, BUFSZ)) == NULL) {
		writeLog(EL,"bdpa_wsreqlic allocate rcvbuf error [%s]",tpstrerror(tperrno));
		sprintf(rqst->data,"9|bdpa_wsreqlic allocate rcvbuf error [%s]",tpstrerror(tperrno));
		tpreturn(TPSUCCESS,0, rqst->data ,0L,0);
	}
	
	memset(rcvbuf,0,BUFSZ);

	/* alocate buffer use send request to main service */
	if((rqst_buf = (char *) tpalloc("STRING", NULL, BUFSZ)) == NULL) {
		writeLog(EL,"bdpa_wsreqlic allocate rqst_buf error [%s]",tpstrerror(tperrno));
		sprintf(rqst->data,"9|bdpa_wsreqlic allocate rqst_buf error [%s]",tpstrerror(tperrno));
		tpfree(rcvbuf);
		tpreturn(TPSUCCESS,0, rqst->data ,0L,0);
	}
	
	memset(rqst_buf,0,BUFSZ);
	tmpbuf = (char *)malloc(BUFSZ);
	strcpy(rqst_buf,rqst->data);
	rtrim(rqst_buf);
	
	strcpy(tmpbuf,rqst_buf);	
	getStrInPite(tmpbuf, chkServicesName);
	rtrim(chkServicesName);
	writeLog(UL,"chkServicesName = [%s]", chkServicesName);
	
	if(atoi(chkServicesName) == 1){
		writeLog(UL,"Data From Web Services");
		/***  Convert  ก่อนส่งไปให้ Main Service ***/
		getStrInPite(rqst_buf, chkServicesName2);
		
		iconv = _iconv_("UTF-8", "TIS-620" , rqst_buf, tmpbuf);
		if(iconv != 0){
			writeLog(EL,"Convert Data (%s) ที่ได้จาก Web Client ไม่ได้\n", rqst_buf);
			writeLog(EL,"rqst_buf = %s", rqst_buf);
			sprintf(rqst->data,"9|bdpa_wsreqlic Convert Data [%s] Error", rqst_buf);
			tpfree(rcvbuf);
			tpfree(rqst_buf);
			free(tmpbuf);
			tpreturn(TPSUCCESS,0, rqst->data ,0L,0);
		}
		
	}else{
		writeLog(UL,"Data From .Net");
		strcpy(tmpbuf,rqst_buf);
	}
	
	/***  ตัดชื่อ Main Service ที่ต้องการ Call ***/
	getStrInPite(tmpbuf, servicesName);
	
	/***  Copy Code & String Data ที่ต้องการ Send To Main Service ***/
	strcpy(rqst_buf,tmpbuf);

	writeLog(UL,"Services Name ==> [%s]",servicesName);
	writeLog(UL,"rqst_buf ==> [%s]",rqst_buf);

	if(strcmp(servicesName , "sdpa_test") == 0){
		writeLog(EL,"rqst_buf = [ %s ]\n", rqst_buf);
		substr(chkCode, rqst_buf, 0, 4);
		
		if(atoi(chkCode) == 1300){
			strcpy(rcvbuf, "1|77|81|กระบี่|10|กรุงเทพมหานคร|71|กาญจนบุรี|46|กาฬสินธุ์|62|กำแพงเพชร|40|ขอนแก่น|22|จันทบุรี|24|ฉะเชิงเทรา|20|ชลบุรี|18|ชัยนาท|36|ชัยภูมิ|86|ชุมพร|57|เชียงราย|50|เชียงใหม่|92|ตรัง|23|ตราด|63|ตาก|26|นครนายก|73|นครปฐม|48|นครพนม|30|นครราชสีมา|80|นครศรีธรรมราช|60|นครสวรรค์|12|นนทบุรี|96|นราธิวาส|55|น่าน|38|บึงกาฬ|31|บุรีรัมย์|13|ปทุมธานี|77|ประจวบคีรีขันธ์|25|ปราจีนบุรี|94|ปัตตานี|14|พระนครศรีอยุธยา|56|พะเยา|82|พังงา|93|พัทลุง|66|พิจิตร|65|พิษณุโลก|76|เพชรบุรี|67|เพชรบูรณ์|54|แพร่|83|ภูเก็ต|44|มหาสารคาม|49|มุกดาหาร|58|แม่ฮ่องสอน|35|ยโสธร|95|ยะลา|45|ร้อยเอ็ด|85|ระนอง|21|ระยอง|70|ราชบุรี|16|ลพบุรี|52|ลำปาง|51|ลำพูน|42|เลย|33|ศรีสะเกษ|47|สกลนคร|90|สงขลา|91|สตูล|11|สมุทรปราการ|75|สมุทรสงคราม|74|สมุทรสาคร|27|สระแก้ว|19|สระบุรี|17|สิงห์บุรี|64|สุโขทัย|72|สุพรรณบุรี|84|สุราษฎร์ธานี|32|สุรินทร์|43|หนองคาย|39|หนองบัวลำภู|15|อ่างทอง|37|อำนาจเจริญ|41|อุดรธานี|53|อุตรดิตถ์|61|อุทัยธานี|34|อุบลราชธานี|");
		}else{
			strcpy(rcvbuf, "1|51|99|*สำนักทะเบียนกลาง|33|เขตคลองเตย|18|เขตคลองสาน|46|เขตคลองสามวา|43|เขตคันนายาว|30|เขตจตุจักร|35|เขตจอมทอง|36|เขตดอนเมือง|26|เขตดินแดง|02|เขตดุสิต|19|เขตตลิ่งชัน|48|เขตทวีวัฒนา|49|เขตทุ่งครุ|15|เขตธนบุรี|20|เขตบางกอกน้อย|16|เขตบางกอกใหญ่|06|เขตบางกะปิ|21|เขตบางขุนเทียน|05|เขตบางเขน|31|เขตบางคอแหลม|40|เขตบางแค|29|เขตบางซื่อ|47|เขตบางนา|50|เขตบางบอน|25|เขตบางพลัด|04|เขตบางรัก|27|เขตบึงกุ่ม|07|เขตปทุมวัน|32|เขตประเวศ|08|เขตป้อมปราบศัตรูพ่าย|14|เขตพญาไท|09|เขตพระโขนง|01|เขตพระนคร|22|เขตภาษีเจริญ|10|เขตมีนบุรี|12|เขตยานนาวา|37|เขตราชเทวี|24|เขตราษฎร์บูรณะ|11|เขตลาดกระบัง|38|เขตลาดพร้าว|45|เขตวังทองหลาง|39|เขตวัฒนา|34|เขตสวนหลวง|44|เขตสะพานสูง|13|เขตสัมพันธวงศ์|28|เขตสาทร|42|เขตสายไหม|23|เขตหนองแขม|03|เขตหนองจอก|41|เขตหลักสี่|17|เขตห้วยขวาง|");
		}
		
		writeLog(EL,"rcvbuf Before Convert = [ %s ]\n", rcvbuf);
		iconv = _iconv_( "TIS-620", "UTF-8" , rcvbuf, tmpbuf);
		strcpy(rcvbuf,tmpbuf);
		tpfree(rqst_buf);
		free(tmpbuf);
		writeLog(EL,"chkCode = [ %s ]\n", chkCode);
		writeLog(EL,"rcvbuf After Convert = [ %s ]\n", rcvbuf);
		tpreturn(TPSUCCESS,0,rcvbuf,0L,0);
	}
	
	/*** ส่งค่าให้ Main Service ***/
	ret = tpacall(servicesName, (char *)rqst_buf, 0, (char **)&rcvbuf, &rcvlen, (long)0);	
	
	if(ret == -1){
		writeLog(EL,"ไม่สามารถ Call Services (%s) ได้ ,tperrno = %d : %s\n",servicesName,tperrno,tpstrerror(tperrno));
		writeLog(EL,"rqst_buf = %s", rqst_buf);
		sprintf(rqst->data,"9|bdpa_wsreqlic Call Services [%s] Error", servicesName);
		tpfree(rcvbuf);
		tpfree(rqst_buf);
		free(tmpbuf);
		tpreturn(TPSUCCESS,0, rqst->data ,0L,0);
	}
	
	if(atoi(chkServicesName) == 1){
		/***  Convert  Data ที่รับจาก Main Service ก่อนส่งไปให้ Client ***/
		writeLog(UL,"Return Data From Services = %s",rcvbuf);
		
		iconv = _iconv_( "TIS-620", "UTF-8" , rcvbuf, tmpbuf);
		if(iconv != 0){
			writeLog(EL,"Convert Data (%s) ที่ได้จาก Services (%s) ไม่ได้\n", rcvbuf, servicesName);
			writeLog(EL,"rqst_buf = %s", rcvbuf);
			sprintf(rqst->data,"9|bdpa_wsreqlic Convert Data [%s] Error", rcvbuf);
			tpfree(rcvbuf);
			tpfree(rqst_buf);
			free(tmpbuf);
			tpreturn(TPSUCCESS,0, rqst->data ,0L,0);
		}
		writeLog(UL,"Convert Data To Web Success");
		strcpy(rcvbuf,tmpbuf);
	}
	
	tpfree(rqst_buf);
	free(tmpbuf);

	tpreturn(TPSUCCESS,0,rcvbuf,0L,0);
}
/***********************************************************************************************************************************************/
void tpsvrdone(void)
{
	writeLog(UL,"Services bdpa_wsreqlic over!");
}
