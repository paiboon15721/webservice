/***********************************************************************************
Create By : Norrapong Huarakkit (QCM)
Create Date : 12/1/58
Create Desc : Business Services (Web services) ��ҧ ����Ѻ �к� E-DOPA
Create Version : 58.01C
***********************************************************************************/
/***********************************************************************************
Modify By : Norrapong Huarakkit (QCM)
Modify Date : 29/5/58
Modify Desc : ��Ѻ��ا���������ͧ�Ѻ��� .NET Client ��� Web Services Client
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
	setLineLength(5120); //��˹�������ǡ����¹�����ŵ�ͺ�÷Ѵ
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
		/***  Convert  ��͹������ Main Service ***/
		getStrInPite(rqst_buf, chkServicesName2);
		
		iconv = _iconv_("UTF-8", "TIS-620" , rqst_buf, tmpbuf);
		if(iconv != 0){
			writeLog(EL,"Convert Data (%s) �����ҡ Web Client �����\n", rqst_buf);
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
	
	/***  �Ѵ���� Main Service ����ͧ��� Call ***/
	getStrInPite(tmpbuf, servicesName);
	
	/***  Copy Code & String Data ����ͧ��� Send To Main Service ***/
	strcpy(rqst_buf,tmpbuf);

	writeLog(UL,"Services Name ==> [%s]",servicesName);
	writeLog(UL,"rqst_buf ==> [%s]",rqst_buf);

	if(strcmp(servicesName , "sdpa_test") == 0){
		writeLog(EL,"rqst_buf = [ %s ]\n", rqst_buf);
		substr(chkCode, rqst_buf, 0, 4);
		
		if(atoi(chkCode) == 1300){
			strcpy(rcvbuf, "1|77|81|��к��|10|��ا෾��ҹ��|71|�ҭ������|46|����Թ���|62|��ᾧྪ�|40|�͹��|22|�ѹ�����|24|���ԧ���|20|�ź���|18|��¹ҷ|36|�������|86|�����|57|��§���|50|��§����|92|��ѧ|23|��Ҵ|63|�ҡ|26|��ù�¡|73|��û��|48|��þ��|30|����Ҫ����|80|�����ո����Ҫ|60|������ä�|12|�������|96|��Ҹ����|55|��ҹ|38|�֧���|31|���������|13|�����ҹ�|77|��ШǺ���բѹ��|25|��Ҩչ����|94|�ѵ�ҹ�|14|��й�������ظ��|56|�����|82|�ѧ��|93|�ѷ�ا|66|�ԨԵ�|65|��ɳ��š|76|ྪú���|67|ྪú�ó�|54|���|83|����|44|�����ä��|49|�ء�����|58|�����ͧ�͹|35|��ʸ�|95|����|45|�������|85|�йͧ|21|���ͧ|70|�Ҫ����|16|ž����|52|�ӻҧ|51|�Ӿٹ|42|���|33|�������|47|ʡŹ��|90|ʧ���|91|ʵ��|11|��طû�ҡ��|75|��ط�ʧ����|74|��ط��Ҥ�|27|������|19|��к���|17|�ԧ�����|64|��⢷��|72|�ؾ�ó����|84|����ɮ��ҹ�|32|���Թ���|43|˹ͧ���|39|˹ͧ�������|15|��ҧ�ͧ|37|�ӹҨ��ԭ|41|�شøҹ�|53|�صôԵ��|61|�ط�¸ҹ�|34|�غ��Ҫ�ҹ�|");
		}else{
			strcpy(rcvbuf, "1|51|99|*�ӹѡ����¹��ҧ|33|ࢵ��ͧ��|18|ࢵ��ͧ�ҹ|46|ࢵ��ͧ�����|43|ࢵ�ѹ�����|30|ࢵ��بѡ�|35|ࢵ����ͧ|36|ࢵ�͹���ͧ|26|ࢵ�Թᴧ|02|ࢵ���Ե|19|ࢵ���觪ѹ|48|ࢵ����Ѳ��|49|ࢵ��觤��|15|ࢵ������|20|ࢵ�ҧ�͡����|16|ࢵ�ҧ�͡�˭�|06|ࢵ�ҧ�л�|21|ࢵ�ҧ�ع��¹|05|ࢵ�ҧࢹ|31|ࢵ�ҧ������|40|ࢵ�ҧ�|29|ࢵ�ҧ����|47|ࢵ�ҧ��|50|ࢵ�ҧ�͹|25|ࢵ�ҧ��Ѵ|04|ࢵ�ҧ�ѡ|27|ࢵ�֧����|07|ࢵ�����ѹ|32|ࢵ������|08|ࢵ������Һ�ѵ�پ���|14|ࢵ����|09|ࢵ���⢹�|01|ࢵ��й��|22|ࢵ������ԭ|10|ࢵ�չ����|12|ࢵ�ҹ����|37|ࢵ�Ҫ���|24|ࢵ��ɮ���ó�|11|ࢵ�Ҵ��кѧ|38|ࢵ�Ҵ�����|45|ࢵ�ѧ�ͧ��ҧ|39|ࢵ�Ѳ��|34|ࢵ�ǹ��ǧ|44|ࢵ�оҹ�٧|13|ࢵ����ѹ�ǧ��|28|ࢵ�ҷ�|42|ࢵ������|23|ࢵ˹ͧ��|03|ࢵ˹ͧ�͡|41|ࢵ��ѡ���|17|ࢵ���¢�ҧ|");
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
	
	/*** �觤����� Main Service ***/
	ret = tpacall(servicesName, (char *)rqst_buf, 0, (char **)&rcvbuf, &rcvlen, (long)0);	
	
	if(ret == -1){
		writeLog(EL,"�������ö Call Services (%s) �� ,tperrno = %d : %s\n",servicesName,tperrno,tpstrerror(tperrno));
		writeLog(EL,"rqst_buf = %s", rqst_buf);
		sprintf(rqst->data,"9|bdpa_wsreqlic Call Services [%s] Error", servicesName);
		tpfree(rcvbuf);
		tpfree(rqst_buf);
		free(tmpbuf);
		tpreturn(TPSUCCESS,0, rqst->data ,0L,0);
	}
	
	if(atoi(chkServicesName) == 1){
		/***  Convert  Data ����Ѻ�ҡ Main Service ��͹������ Client ***/
		writeLog(UL,"Return Data From Services = %s",rcvbuf);
		
		iconv = _iconv_( "TIS-620", "UTF-8" , rcvbuf, tmpbuf);
		if(iconv != 0){
			writeLog(EL,"Convert Data (%s) �����ҡ Services (%s) �����\n", rcvbuf, servicesName);
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
