import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PharmecyListComponent } from './pharmecy-list.component';

describe('PharmecyListComponent', () => {
  let component: PharmecyListComponent;
  let fixture: ComponentFixture<PharmecyListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [PharmecyListComponent]
    });
    fixture = TestBed.createComponent(PharmecyListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
